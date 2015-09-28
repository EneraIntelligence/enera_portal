<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class UserFacebook extends Model
{
    protected $collection = null;
    protected $fillable = ['name', 'birthday', 'email', 'location', 'gender', 'likes', 'id'];
}
