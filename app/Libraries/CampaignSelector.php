<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 9/25/15
 * Time: 10:32 AM
 */

namespace Portal\Libraries\Interactions;

use Portal\User;
use Portal\Campaign;
use MongoDate;
use Portal\Http\Requests;
use Portal\Http\Controllers\Controller;
use Portal\Libraries\Interactions;

class CampaignSelector
{
    protected $user;
    protected $campaign;

    /**
     * CampaignSelector constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user = User::find($user_id);
        $this->campaign = $this->selector();
        $this->age = $this->getAge();
    }

    private function selector()
    {
        // TODO aqui la consulta para obtener la(s) campaña(s) adecuada(s) al usuario
        $campaing = Campaign::orderBy('balance', 'desc')->Where(function ($q)
        {
            $day = date('w');
            $hours = date('H');
            $q->whereIn('filter.week_days', [$day] )->whereIn('filter.week_hours', [$hours]);
        })->Where(function ($q)
        {
            $q->whereIn('filter.age', [$this->age]);
        })->where(function ($q)
        {
            $now= date('Y-m-d',time());
            $DateBegin = date('Y-m-d', $this->user->filter['date']['start']->sec);
            $DateEnd = date('Y-m-d', $this->user->filter['date']['end']->sec);

            $q->where($now, '>' ,$DateBegin)->where($now, '<', $DateEnd);

        })->whereIn('filter.gender', [$this->user->facebook['gender']])->where('status', 'active')->get();
        return $campaing;
    }

    private function getAge(){
        $fb_birthday = explode("-",date("Y-m-d", $this->user->facebook['birthday']['date']));
        $date_now = explode("-",date("Y-m-d"));

        $age = $date_now[0]-$fb_birthday[0];
        if($date_now[1]<=$fb_birthday[1] and $date_now[2]<=$fb_birthday[2]){
            $age = $age - 1;
        }
         return $age;

    }
}