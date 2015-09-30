<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class CampaignLog extends Model
{
    protected $fillable = ['user', 'device', 'interaction', 'cost'];

    // relations
    public function campaign()
    {
        return $this->belongsTo('Portal\Campaign');
    }
    // end relations
}