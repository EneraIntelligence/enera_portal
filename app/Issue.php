<?php

namespace Portal;

use Jenssegers\Mongodb\Model as Model;

class Issue extends Model
{
    protected $fillable = ['msg', 'platform', 'environment', 'url', 'file', 'exception', 'responsible_id',
        'priority', 'status', 'history', 'session_vars'];

    // relations
    public function reponsible()
    {
        return $this->belongsTo('Portal\Administrator', 'responsible_id');
    }
    // end relations
}
