<?php

namespace App\Http\traits;

trait responseTrait
{
    public function response($status, $message, $data, $is_error=false)
    {
        return response()->json(['is_error'=>$is_error,'message'=>$message,'data'=>$data], $status);
    }
}
