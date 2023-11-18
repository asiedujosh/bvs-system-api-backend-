<?php

namespace App\Exceptions;

use Exception;

class IndividualException extends Exception
{
    //
    public function report(){

    }

    /**
     * Render the exception as an HTTP response.
     * 
     * @param \Illuminate\Http\Request $request
     */

     public function render($request)
     {
        return new JsonResponse([
            'errors' => [
                    'message' =>$this.getMessage(),
                ]
                ], $this->code);
     }
}
