<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class UserFacebook extends Model
{
    protected $fillable = ['name', 'birthday', 'email', 'lo cation', 'gender', 'likes', 'id'];
    protected $collection = null;

    // relations

    // end relations
}
