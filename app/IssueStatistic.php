<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class IssueStatistic extends Model
{
    protected $fillable = ['date', 'recurrence', 'host'];
    protected $dates = ['created_at', 'updated_at'];
    // relations

    // end relations
}
