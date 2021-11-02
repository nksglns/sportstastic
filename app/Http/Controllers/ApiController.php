<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function respond($data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }

    public function respondStatusOnly($statusCode = 200)
    {
        return response()->noContent($statusCode);
    }
}
