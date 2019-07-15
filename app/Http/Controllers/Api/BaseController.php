<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


class BaseController extends Controller
{

    public function sendResponse($result)
    {

        // $response = [
        //        'success' => true,
        //        'data'    => $result,
        //        'message' => $message,
        //    ];

        return response()->json($result, 200);
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
