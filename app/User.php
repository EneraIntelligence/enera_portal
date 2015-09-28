<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class User extends Model
{
    protected $fillable = ['facebook'];

    // relations
    public function facebook()
    {
        return $this->embedsOne('Portal\UserFacebook');
    }
    // end relations
}
