<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class UserDevice extends Model
{
    protected $fillable = ['mac', 'os', 'manufacturer'];
    protected $collection = null;
    // relations

    // end relations
}
