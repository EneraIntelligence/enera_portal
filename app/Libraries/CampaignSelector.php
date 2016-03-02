<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:32 AM
 */

namespace Portal\Libraries;

use Carbon\Carbon;
use DateTime;
use Input;
use Portal\AccessPoint;
use Portal\Branche;
use Portal\User;
use Portal\Campaign;
use Portal\CampaignLog;
use MongoDate;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\Interactions;

class CampaignSelector
{
    protected $user;
    public $campaign;

    /**
     * CampaignSelector constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user = User::find($user_id);
        $this->campaign = $this->selector();

    }

    private function selector()
    {
        // TODO aqui la consulta para obtener la(s) campaña(s) adecuada(s) al usuario
        $unique = $this->unique();
        $unique_per_day = $this->unique_user_day();
        $branch = Branche::whereIn('aps', [Input::get('node_mac')])->first();
        $max = $this->max();
        $video = $this->video();
        $user = $this->user;
        $birthday = new DateTime(isset($this->user->facebook->birthday['date']) ? $this->user->facebook->birthday['date'] : Carbon::today()->subYears(18)->toDateTimeString());
        $today = date('Y-m-d');
        $age = $birthday->diff(new DateTime($today));


        $campaign = Campaign::whereRaw([

            'filters.age.0' => [
                '$lte' => $age->y
            ],
            'filters.age.1' => [
                '$gte' => $age->y
            ],
            'filters.date.start' => [
                '$lte' => new MongoDate(strtotime($today))
            ],
            'filters.date.end' => [
                '$gte' => new MongoDate(strtotime($today))
            ],
            'filters.week_days' => [
                '$in' => [intval(date('w'))]
            ],


            'filters.day_hours' => [
                '$in' => [intval(date('H'))]
            ],
            'filters.gender' => [
                '$in' => [$this->user->facebook['gender']]
            ]
        ])->where(function ($q) use ($user) {
            if (!isset($user->facebook->email)) {
                $q->whereRaw([
                    'interaction.name' => [
                        '$ne' => 'mailing_list'
                    ]
                ]);
            } else {
                $q->whereNotIn('mailing_list', [$user->facebook->email]);
            }
        })
            ->whereNotIn('_id', $unique)
            ->whereNotIn('_id', $unique_per_day)
            ->whereNotIn('_id', $max)
            ->whereNotIn('_id', $video)
            ->where(function ($q) use ($branch) {
                if ($branch->filters['external_ads']) {
                    $q->whereIn('branches', [$branch->_id, 'all']);
                } else {
                    $q->whereIn('branches', [$branch->_id]);
                }
            })
            ->where('status', 'active')
            ->orderBy('balance.current', 'desc')
            ->get();

        return $campaign;

    }

    private function unique()
    {
        $unique_user = Campaign::where('filters.unique_user', true)
            ->where('status', 'active')->lists('_id');

        $filter = CampaignLog::whereIn('campaign_id', $unique_user)
            ->where('user.id', $this->user)
            ->where('interaction.completed', 'exists', true)
            ->lists('campaign_id');

        return $filter;
    }

//    Filtra las campañas donde el usuario ya participo y la campaña es de usuario unico
    private function unique_user_day()
    {

        $today = date('Y-m-d');
        $unique_user = Campaign::where('filters.unique_user', true)
            ->where('status', 'active')->lists('_id');

        $campaings_log = CampaignLog::whereIn('campaign_id', $unique_user)->where('device.mac', Input::get('client_mac'))
            ->where('interaction.completed', new MongoDate(strtotime($today)))->lists('campaign_id');

        return $campaings_log;
    }

    private function max()
    {

        $today = date('Y-m-d');
        $max_unique = Campaign::where('filters.max_interactions', 'true')
            ->where('status', 'active')->lists('_id');

        //echo $max_unique. '<br>';
        $filter = [];
        foreach ($max_unique as $max) {
            $count = CampaignLog::where('campaign_id', $max)
                ->where('interaction.completed', new MongoDate(strtotime($today)))->count();

            $campaign = Campaign::where('_id', $max)
                ->where('filters.max_interactions_per_day', '<=', $count)->first();
            array_push($filter, $campaign);
        }

        return $filter;

    }

//    Obtiene los branch_id asociados al AP actual
    private function aps()
    {
        $branches = AccessPoint::where('mac', Input::get('node_mac'))->lists('branch_id');

        $filter = [];
        foreach ($branches as $branche) {
            $cam = Campaign::whereIn('branches', $branches)->lists('_id');
            foreach ($cam as $c)
                array_push($filter, $c);
        }

        return array_unique($filter);

    }

    private function video()
    {
        if (session('device_os') == 'Iphone') {
            $videos = Campaign::where('interaction.name', "video")->lists('_id');
        } else {
            $videos = [];
        }
        return $videos;
    }
}