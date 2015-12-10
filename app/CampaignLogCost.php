<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class CampaignLogCost extends Model
{
    protected $fillable = ["balance_before", "balance_after", "base", "multiplier", "amount"];
    protected $collection = null;

    // relations
    
    // end relations
}
