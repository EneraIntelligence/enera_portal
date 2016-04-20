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
use MongoDate;
use Portal\Issue;
use Session;

class IssueTrackerHelper
{
    /**
     * @param Request $request
     * @param Exception $e
     * @param $plataform
     * @param int $responsible
     * @internal param array $data
     */
    public static function create(Request $request, Exception $e, $plataform, $responsible = 0)
    {
        /* Genera URL actual */
        if (count($_GET) > 0) {
            $url = '?';
            foreach ($_GET as $k => $v) {
                $url .= $k . '=' . $v . '&';
            }
        } else {
            $url = '';
        }

        /* Extrae el contexto del archivo */
        $context = '';
        $file = file($e->getFile());
        $i = $e->getLine() > 10 ? $e->getLine() - 10 : 0;
        for ($i; $i <= $e->getLine() + 10; $i++) {
            $context .= isset($file[$i]) ? $file[$i] : '';
        }

        $instance = explode('\\', get_class($e));
        $issue_title = $instance[count($instance) - 1] . ' ' . $request->method() . ' /' . $request->path();
        $issue_file_path = str_replace(base_path(), '', $e->getFile());
        $issue_file_line = $e->getLine();

        $issue = Issue::where('issue.title', $issue_title)
            ->where('issue.file.path', $issue_file_path)
            ->where('issue.file.line', $issue_file_line)
            ->where('issue.platform', $plataform)->first();

        if ($issue) {
            $issue->recurrence()->create([
                'request' => [
                    'url' => $request->url() . $url,
                    'host' => gethostname(),
                    'platform' => $plataform,
                    'environment' => env('APP_ENV', 'local'),
                    'session_vars' => Session::all(),
                ],
                'exception' => [
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTraceAsString(),
                ]
            ]);

            dd($issue);

            $issue_statistic = $issue->statistic
                ->where('date', new MongoDate(strtotime(date('Y-m-d') . 'T00:00:00-0600')))->first();

            dd($issue_statistic);

            if ($issue_statistic) {
                $issue_statistic->recurrence += 1;
                $issue_statistic->host[gethostname()] += 1;
                $issue_statistic->save();
            } else {
                $issue->statistic()->create([
                    'date' => new MongoDate(strtotime(date('Y-m-d') . 'T00:00:00-0600')),
                    'recurrence' => 1,
                    'host' => [
                        gethostname() => 1
                    ]
                ]);
            }
        } else {
            /* Creacion de Issue */
            $issue = Issue::create([
                'issue' => [
                    'title' => $issue_title,
                    'file' => [
                        'line' => $issue_file_line,
                        'path' => $issue_file_path,
                        'context' => $context,
                    ],
                    'platform' => $plataform,
                ],
                'exception' => [
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTraceAsString(),
                ],
                'statistic' => [],
                'recurrence' => [],
                'responsible_id' => $responsible,
                'priority' => 'error',
                'status' => 'pending',
                'history' => [],
            ]);

            $issue->recurrence()->create([
                'request' => [
                    'url' => $request->url() . $url,
                    'host' => gethostname(),
                    'platform' => $plataform,
                    'environment' => env('APP_ENV', 'local'),
                    'session_vars' => Session::all(),
                ],
                'exception' => [
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'trace' => $e->getTraceAsString(),
                ]
            ]);

            $issue->statistic()->create([
                'date' => new MongoDate(strtotime(date('Y-m-d') . 'T00:00:00-0600')),
                'recurrence' => 1,
                'host' => [
                    gethostname() => 1
                ]
            ]);
        }
    }
}