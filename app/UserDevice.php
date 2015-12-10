<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class UserDevice extends Model
{
    protected $fillable = ['mac', 'os', 'manufacturer'];
    protected $collection = null;

    // relations
    public function data()
    {
        return $this->belongsTo('Portal\Device', 'mac', 'mac');
    }
    // end relations
}
