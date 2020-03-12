<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        if($exception instanceof ValidationException)
        {
                return $this->convertValidationExceptionToResponse($exception,$request);
        }
         //investigar ModelNotFoundException
        if ($exception instanceof  ModelNotFoundException)
        {
            $modelo = strtolower(class_basename($exception->getModel()));
            return  $this->errorResponse("No existe ninguna instancia de {$modelo} expecificado", 404 );
        }
        if($exception instanceof AuthenticationException)
        {
            return $this->unauthenticated($request, $exception);
        }
        /*condicional cuando no este autorizado*/

        if ($exception instanceof AuthorizationException)
        {
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }
        if ($exception instanceof NotFoundHttpException)
        {
            return $this->errorResponse('No se encontró la URL especificada', 404);
        }
        if($exception instanceof MethodNotAllowedHttpException)
        {
            return $this->errorResponse('El metodo especificado en la peticion no es válido', 405);
        }
        if ( $exception instanceof HttpException )
        {
        return  $this->errorResponse ( $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof QueryException)
        {
            dd($exception);
            $codigo = $exception->errorInfo[1];
             if ($codigo == 1451) {
                    return $this->errorResponse('No se puede eliminar de forma permamente el recurso porque está relacionado con algún otro.', 409);
                }

        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */

    /*modificamos el metodo de modo que siempre este retornando una respuesta de tipo json */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('no autenticado',401);

    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return  $this->errorResponse($errors, 422);

    }
}
