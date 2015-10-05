<?php namespace App\Exceptions;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
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
     * @return \Illuminate\Httpresponse()->
     */
    public function render($request, Exception $e)
    {
        if($request->isJson() || $request->wantsJson())
        {
            if($this->isModelNotFoundException($e))
            {
                $data = ['error' => ['model' => ['error.model.404']]];
                if(app('app')->environment('production') == false)
                {
                    $data['context'] = ['model' => $e->getModel()];
                }
                return response()->json($data, 404);
            }
            else
            {
                $code = 500;
                if($this->isHttpException($e))
                {
                    $code = $e->getStatusCode();
                }
                $data = ['error' => ['http' => ['error.http.' . $code]]];
                if(app('app')->environment('production') == false)
                {
                    $data['context'] = [
                        'exception' => [
                            'code' => $e->getCode(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            'message' => $e->getMessage(),
                            'trace' => $e->getTrace(),
                        ]
                    ];
                }
                return response()->json($data, 500);
            }
        }
        return parent::render($request, $e);
    }
    private function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }
}