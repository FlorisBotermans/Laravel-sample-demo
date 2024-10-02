<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    protected $code = 422;
    /**
     * Report the exception
     * 
     * @return void
     */
    // The report() method is responsible for reporting or logging the exception.
    // public function report()
    // {
    //     dump('abcccc');
    // }

    /**
     * Render the exception as an HTTP response.
     * 
     * @param \Illuminate\Http\Request $request
     */
    // The render() method is responsible to send the error back to the HTTP client.
    public function render($request)
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->getMessage(),
            ]
        ], $this->code);
    }
}
