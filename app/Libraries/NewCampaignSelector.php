<?php
/**
 * Created by PhpStorm.
 * User: ARodriguez
 * Date: 11/9/16
 * Time: 10:17
 */

namespace Portal\Libraries;


use Carbon\Carbon;
use DB;
use MongoDate;
use Portal\Branche;
use Portal\Campaign;
use Portal\CampaignLog;
use Portal\User;

class NewCampaignSelector
{

    public static function allUsers()
    {
        $uniqueCampaign = self::uniqueTime(); //Campañas con interaccion unica por usuario
        $uniquePerDay = self::uniqueTimePerDay(); //Campañas con interaccion unica por día
        $maxInteractions = self::maxInteractions(); //campañas con limite de intercciones
        $maxInteractionsPerDay = self::maxInteractionPerDay(); //campañas con limite de intercciones  por día
        $weekday = self::campaignPerWeekDay(); //campañas filtardas por día de la semana
        $hour = self::campaignPerHour(); //camapañas filtradas por hora del día
        $period = self::periodTime(); //Verifica el periodo de vida de las campañas
        $branch = self::perBranch();


        $campaigns = Campaign::where('status', 'active')
            ->whereNotIn('_id', $uniquePerDay)
            ->whereNotIn('_id', $maxInteractions)
            ->whereNotIn('_id', $maxInteractionsPerDay)
            ->whereIn('_id', $weekday)
            ->whereIn('_id', $hour)
            ->whereIn('_id', $period)
            ->whereIn('_id', $branch)
            ->whereNotIn('_id', $uniqueCampaign)
            ->get();

        return $campaigns;
    }

    public static function facebookUsers($user_id)
    {
        $user = User::where('_id', $user_id)->first();
        $today = Carbon::now();
        $age = $today->diffInYears(Carbon::parse(date('Y-M-d h:i:s', $user['facebook']['age']->sec)));

        $uniqueCampaign = self::uniqueTime(); //Campañas con interaccion unica por usuario
        $uniquePerDay = self::uniqueTimePerDay(); //Campañas con interaccion unica por día
        $maxInteractions = self::maxInteractions(); //campañas con limite de intercciones
        $maxInteractionsPerDay = self::maxInteractionPerDay(); //campañas con limite de intercciones  por día
        $weekday = self::campaignPerWeekDay(); //campañas filtardas por día de la semana
        $hour = self::campaignPerHour(); //camapañas filtradas por hora del día
        $period = self::periodTime(); //Verifica el periodo de vida de las campañas
        $branch = self::perBranch();

        $campaigns = Campaign::where('status', 'active')
            ->whereNotIn('_id', $uniqueCampaign)
            ->whereNotIn('_id', $uniquePerDay)
            ->whereNotIn('_id', $maxInteractions)
            ->whereNotIn('_id', $maxInteractionsPerDay)
            ->whereIn('_id', $weekday)
            ->whereIn('_id', $hour)
            ->whereIn('_id', $period)
            ->whereIn('_id', $branch)
            ->whereIn('filters.gender', [$user['facebook']['gender']])
            ->Where('filters.age.0', '<=', $age)->where('filters.age.1', '>=', $age)
            ->get();


        return $campaigns;
    }

    private static function uniqueTime()
    {
        $campaigns = Campaign::where('filters.unique_user', true)
            ->where('status', 'active')->lists('_id');

        $filter = CampaignLog::whereIn('campaign_id', $campaigns)
            ->where('user.mac', session('client_mac'))
            ->where('interaction.completed', 'exists', true)
            ->lists('campaign_id');

        return $filter->all();
    }

    private static function uniqueTimePerDay()
    {
        $today = Carbon::now();
        $campaign_unique_per_day = Campaign::where('filters.unique_user', true)
            ->where('status', 'active')->lists('_id');

        $filter = CampaignLog::whereIn('campaign_id', $campaign_unique_per_day)->where('device.mac', session('client_mac'))
            ->where('interaction.completed', new MongoDate(strtotime($today)))->lists('campaign_id');

        return $filter->all();
    }

    private static function maxInteractions()
    {
        $campaign_max_interactions = Campaign::where('filters.max_interactions', '>', 0)
            ->where('status', 'active')->lists('_id');

        $filter = [];
        foreach ($campaign_max_interactions->all() as $campaign_max) {
            $count = CampaignLog::where('campaign_id', $campaign_max)
                ->where('interaction.completed', 'exists', true)->count();

            $campaign = Campaign::where('_id', $campaign_max)
                ->where('filters.max_interactions', '<', $count)->first();
            if ($campaign)
                array_push($filter, $campaign['_id']);
        }

        return $filter;
    }

    private static function maxInteractionPerDay()
    {
        $today = Carbon::today();
        $campaign_max_interaction_per_day = Campaign::where('filters.max_interactions_per_day', '>', 0)
            ->where('status', 'active')->lists('_id');

        $filter = [];
        foreach ($campaign_max_interaction_per_day->all() as $campaign_max) {
            $count = CampaignLog::where('campaign_id', $campaign_max)
                ->where('interaction.completed', new MongoDate(strtotime($today)))->count();

            $campaign = Campaign::where('_id', $campaign_max)
                ->where('filters.max_interactions', '<', $count)->first();
            array_push($filter, $campaign['_id']);
        }

        return $filter;

    }

    private static function campaignPerWeekDay()
    {
        $today = Carbon::today()->dayOfWeek;
        $campaign_per_weekday = Campaign::whereIn('filters.week_days', [$today])
            ->where('status', 'active')->lists('_id');

        return $campaign_per_weekday->all();
    }

    private static function campaignPerHour()
    {
        $hour = Carbon::now()->hour;
        $campaign_per_hour = Campaign::whereIn('filters.day_hours', [$hour])
            ->where('status', 'active')->lists('_id');

        return $campaign_per_hour->all();
    }

    private static function periodTime()
    {
        $today = Carbon::now();
        $campaign = Campaign::where('filters.date.start', '<=', new MongoDate(strtotime($today)))
            ->where('filters.date.end', '>=', new MongoDate(strtotime($today)))->where('status', 'active')->lists('_id');

        return $campaign->all();
    }

    private static function perBranch()
    {
        $branch = Branche::whereIn('aps', [session('node_mac')])
            ->lists('_id');

        $filter = Campaign::whereIn('branches', $branch->all())->where('status', 'active')->lists('_id');


        return $filter->all();
    }
}