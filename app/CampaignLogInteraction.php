<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class CampaignLogInteraction extends Model
{
    protected $fillable = ['welcome', 'joined', 'requested', 'loaded', 'completed'];
    protected $collection = null;
    // relations

    // end relations
}
