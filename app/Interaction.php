<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class Interaction extends Model
{
    protected $fillable = ['name', 'amount', 'rules','status'];

}
