<?php

namespace Portal\Exceptions;

use Exception;
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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //redirect to welcome when we have a facebook error
        if($e instanceof FacebookSDKException)
        {
            return redirect()->route('welcome', [
                'base_grant_url' => Input::get('base_grant_url'),
                'user_continue_url' => Input::get('user_continue_url'),
                'node_mac' => Input::get('node_mac'),
                'client_ip' => Input::get('client_ip'),
                'client_mac' => Input::get('client_mac')
            ]);
        }

        return parent::render($request, $e);
    }
}
