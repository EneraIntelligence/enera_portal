<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

//use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // relations
    public function users()
    {
        return $this->hasMany('Portal\User','devices.mac','mac');
    }
    // end relations
}
