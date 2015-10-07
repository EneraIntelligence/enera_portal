<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

//use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['client_id', 'name', 'branches', 'balance', 'interaction', 'filters', 'content', 'status', 'mailing_list'];

    // relations
    public function logs()
    {
        return $this->hasMany('Portal\CampaignLog');
    }
    // end relations
}
