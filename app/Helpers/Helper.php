<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class Helper
{

    public static function jsonResponse($resStatusCode, $resMessage, $resData = null)
    {
        $metadata = [
            'message' => $resMessage,
            'statusCode' => $resStatusCode,
            'code' => $resStatusCode,
            'date' => Carbon::now()->toDateTimeString(),
        ];

        $response = [
            'metadata' => $metadata,
            'data' => $resData,
        ];

        return response()->json($response, $resStatusCode);
    }

}
