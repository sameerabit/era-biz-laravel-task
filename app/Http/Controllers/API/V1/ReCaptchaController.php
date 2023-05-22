<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReCaptchaRequest;
use Illuminate\Http\Request;

class ReCaptchaController extends Controller
{
    public function verify(ReCaptchaRequest $reCaptchaRequest)
    {
        return response([
            'message' => 'valid token'
        ]);
    }
}
