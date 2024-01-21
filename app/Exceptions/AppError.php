<?php

namespace App\Exceptions;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

class AppError extends \Exception
{

    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public function report(){
        Log::channel("app")->error($this->getMessage());
    }

    public function render($request){
        if ($request->is('api/*')) {
            return Helper::jsonResponse($this->getCode(), $this->getMessage());
        }
        return abort($this->getCode(), $this->getMessage());
    }
}
