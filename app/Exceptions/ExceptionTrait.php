<?php

namespace App\Exceptions;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GuzzleHttp\Psr7\Response;

trait ExceptionTrait
{
    public function apiException($request, $exception)
    {
        // show error json formart
        if($this->isModel($exception))
        {
            return $this->ModelResponse($exception);
        }
        
        // show error route link
        if($this->isHTTP($exception)){
             return $this->HttpResponse($exception);
        }

        return parent::render($request, $exception);
    }

    protected function isModel($exception)
    {
        return $exception instanceof ModelNotFoundException;
    }

    protected function isHTTP($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function ModelResponse($exception)
    {
        return response()->json([
            'error' => "Product not not found"
        ],404);
    }

    protected function HttpResponse($exception)
    {
        return response()->json([
            'error' => "Incorrect route"
        ],404);
    }
}