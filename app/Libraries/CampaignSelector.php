<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:32 AM
 */

namespace Portal\Libraries;

use DateTime;
use Portal\User;
use Portal\Campaign;
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
        $date = explode(' ', $this->user['facebook']['birthday']['date']);
        $fb_date = explode('-', $date[0]);
        $birthday = new DateTime($fb_date[0] . '-' . $fb_date[1] . '-' . $fb_date[2]);
        $today = new DateTime(date('Y-m-d'));
        $campaign = Campaign::where(function ($q) use ($birthday, $today) {
            $q->where('filters.age.0', '<='[$birthday->diff($today)])
                ->where('filters.age.1', '>='[$birthday->diff($today)]);
        })->where(function ($q) use ($today) {
            $q->where('filters.date.start', '<=', new DateTime($today))
                ->where('filters.date.end', '>=', new DateTime($today));
        })
            ->whereIn('filters.week_days', [date('w')])
            ->whereIn('filter.day_hours', [date('H')])
            ->whereIn('filters.gender', [$this->user['facebook']['gender']])
            ->where('status', 'active')
            ->orderBy('balance', 'desc')
            ->get();

        return $campaign;
    }
}