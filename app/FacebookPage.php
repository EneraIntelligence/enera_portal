<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class FacebookPage extends Model
{
    protected $fillable = ['name', 'category', 'category_list', 'id'];
}
