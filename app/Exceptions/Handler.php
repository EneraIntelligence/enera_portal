<?php

namespace Portal\Exceptions;

use Carbon\Carbon;
use Exception;
use Mail;
use Portal\Libraries\IssueTrackerHelper;
use Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
//use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;
use Facebook\Exceptions\FacebookSDKException;
use Input;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\Response
     * @internal param Exception $ex
     * @internal param Exception $e
     */
    public function render($request, Exception $e)
    {
        /*Mail::send('mail.issuestracker', [
            'ex' => $e,
            'request' => $request,
            'session_vars' => Session::all(),
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
        ], function ($mail) use ($e) {
            $mail->from('servers@enera.mx', 'Enera Servers');
            $mail->to('issuestracker@enera.mx', 'Enera IssuesTracker')->subject('IssuesTracker - ' . $e->getMessage());
        });*/

        //redirect to welcome when we have a facebook error
        if ($e instanceof FacebookSDKException) {
            IssueTrackerHelper::create($request, $e, 'Portal');
            return redirect()->route('welcome', [
                'base_grant_url' => Input::get('base_grant_url'),
                'user_continue_url' => Input::get('user_continue_url'),
                'node_mac' => Input::get('node_mac'),
                'client_ip' => Input::get('client_ip'),
                'client_mac' => Input::get('client_mac')
            ]);
        }
        $debug = env('APP_DEBUG');
        if ($debug == 0) {
            if ($e instanceof NotFoundHttpException) {
                return response()->view('error.404', [], 404);
            } else if ($e instanceof FatalErrorException) {
                IssueTrackerHelper::create($request, $e, 'Portal');
                return response()->view('errors.503', [], 503);
            } else if ($e instanceof Exception) {
                IssueTrackerHelper::create($request, $e, 'Portal');
                return response()->view('errors.500', [], 500);
            } else {
                IssueTrackerHelper::create($request, $e, 'Portal');
                return response()->view('errors.500', [], 500);
            }
        } elseif ($debug == 1) {
            if ($e instanceof ModelNotFoundException) {
                $e = new NotFoundHttpException($e->getMessage(), $e);
            }
            IssueTrackerHelper::create($request, $e, 'Portal');
            return parent::render($request, $e);
        }
    }
}
