<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class InputLog extends Model
{
    /*
    protected $fillable = ['user', 'device', 'interaction', 'cost'];

    // relations
    public function campaign()
    {
        return $this->belongsTo('Portal\Campaign');
    }

    public function interaction()
    {
        return $this->embedsOne('Portal\CampaignLogInteraction');
    }

    public function user()
    {
        return $this->belongsTo('Portal\User', 'user.id');
    }

    public function cost()
    {
        return $this->embedsOne('Portal\CampaignLogCost');
    }*/

    // end relations
}