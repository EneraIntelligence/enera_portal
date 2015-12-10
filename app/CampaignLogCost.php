<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class CampaignLogCost extends Model
{
    protected $fillable = ["balance_before", "balance_after", "base", "multiplier", "amount"];
    protected $collection = null;

    // relations

    public function campaign_log()
    {
        return $this->belongsTo('Portal\CampaignLog');
    }

    // end relations
}
