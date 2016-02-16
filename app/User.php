<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class User extends Model
{
    protected $fillable = ['facebook', 'devices'];

    // relations
    public function facebook()
    {
        return $this->embedsOne('Portal\UserFacebook');
    }

    public function devices()
    {
        return $this->embedsMany('Portal\UserDevice');
    }
// end relations
}
