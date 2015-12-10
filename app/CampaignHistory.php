<?php

namespace Portal;

use Jenssegers\Mongodb\Model;

class CampaignHistory extends Model
{
    protected $fillable = ['administrator_id', 'status', 'date', 'note'];
    protected $collection = null;
    protected $dates = ['date'];
    // relations

    // end relations
}
