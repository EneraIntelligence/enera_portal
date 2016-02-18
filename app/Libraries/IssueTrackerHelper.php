<?php
/**
 * Created by PhpStorm.
 * User: pedroluna
 * Date: 2/17/16
 * Time: 5:47 PM
 */

namespace Portal\Libraries;


use Exception;
use File;
use \Illuminate\Http\Request;
use Portal\Issue;
use Session;

class IssueTrackerHelper
{
    /**
     * @param Request $request
     * @param Exception $e
     * @param $plataform
     * @internal param array $data
     */
    public static function create(Request $request, Exception $e, $plataform)
    {
        /* Genera URL actual */
        $url = '?';
        foreach ($_GET as $k => $v) {
            $url .= $k . '=' . $v . '&';
        }

        /* Extrae el contexto del archivo */
        $context = '';
        $file = file($e->getFile());
        $i = $e->getLine() > 10 ? $e->getLine() - 10 : 0;
        for ($i; $i <= $e->getLine() + 10; $i++) {
            $context .= isset($file[$i]) ? $file[$i] . '<br>' : '';
        }

        /* Creacion de Issue */
        Issue::create([
            'msg' => $e->getMessage() != '' ? $e->getMessage() : 'IssueTracket Error',
            'platform' => $plataform,
            'environment' => env('APP_ENV', 'local'),
            'url' => $request->url() . $url,
            'file' => [
                'line' => $e->getLine(),
                'path' => $e->getFile(),
                'context' => '"'.$context.'"',
            ],
            'exception' => [
                'code' => $e->getCode(),
                'trace' => $e->getTrace(),
            ],
            'session_vars' => Session::all(),
            'responsible_id' => 0,
            'priority' => 'error',
            'status' => 'active',
            'history' => [],
        ]);
    }
}