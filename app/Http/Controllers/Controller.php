<?php

namespace App\Http\Controllers;

abstract class Controller
{

    protected function jsonSuccess($data = [], $msg = "Sucesso!")
    {
        return response()->json([
            "data"      => $data,
            "message"   => $msg
        ]);
    }

    protected function jsonError($msg, $code = 512)
    {
        return response()->json([
            "message"   => $msg,
            "is_array"  => false
        ], $code);
    }
    
}
