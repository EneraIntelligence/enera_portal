<?php

namespace Publishers;

use Jenssegers\Mongodb\Model;


class Administrator extends Model
{
    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $table = 'administrators';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // relations
    public function client()
    {
        return $this->belongsTo('Portal\Client');
    }

    public function role()
    {
        return $this->belongsTo('Portal\Role');
    }

    public function campaigns()
    {
        return $this->hasMany('Portal\Campaign');
    }

    public function subcampaigns()
    {
        return $this->hasMany('Portal\Subcampaign');
    }
    // end relations
}
