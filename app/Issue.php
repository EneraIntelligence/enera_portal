<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class Issue extends Model
{
    protected $fillable = ['issue', 'exception', 'statistic', 'recurrence', 'responsible_id', 'priority', 'status', 'history'];
    protected $dates = ['created_at', 'updated_at'];

    // relations
    public function reponsible()
    {
        return $this->belongsTo('Portal\Administrator', 'responsible_id');
    }

    public function recurrence()
    {
        return $this->embedsMany('Portal\IssueRecurrence');
    }

    public function statistic()
    {
        return $this->embedsMany('Portal\IssueStatistic');
    }
    // end relations
}
