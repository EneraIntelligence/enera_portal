<?php

namespace Portal;

use Jenssegers\Mongodb\Model;

class Campaign extends Model
{
    protected $fillable = ['client_id', 'administrator_id', 'name', 'branches', 'interaction', 'filter', 'content',
        'log', 'status'];

    // relations
    public function administrator()
    {
        return $this->belongsTo('Portal\Administrator');
    }

    public function interaction()
    {
        return $this->belongsTo('Portal\Interaction', 'interaction.id');
    }

    public function logs()
    {
        return $this->hasMany('Portal\CampaignLog');
    }

    public function history()
    {
        return $this->embedsMany('Portal\CampaignHistory', 'history');
    }
    // end relations
}
