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
        $birthday = new DateTime($this->user->facebook->birthday['date']);
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
        ])->where('status', 'active')
            ->orderBy('balance', 'desc')
            ->get();

        return $campaign;
    }
}