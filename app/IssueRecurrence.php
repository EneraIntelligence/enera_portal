<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class IssueRecurrence extends Model
{
    protected $fillable = ['request', 'exception'];
    protected $dates = ['created_at', 'updated_at'];
    // relations

    // end relations
}
