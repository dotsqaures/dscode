<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($exception->getMessage(), $exception);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return abort('503');
        }


        if($exception instanceof \Illuminate\Session\TokenMismatchException){

            if (strpos($request->getRequestUri(), '/logout') !== false) {
                $prefix = str_replace("/","",$request->route()->getPrefix());
                if($prefix != "admin"){
                    auth()->guard('web')->logout();
                    return redirect()
                                ->route('login')
                                ->with(['alert_type' => 'success', 'alert_message' => __('auth.logged_out')]);
                }else{
                    auth()->guard('admin')->logout();
                    return redirect()
                    ->route('admin.login')
                    ->with(['alert_type' => 'success', 'alert_message' => __('auth.logged_out')]);
                }
           }
         }
        return parent::render($request, $exception);
    }
}
