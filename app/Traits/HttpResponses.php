<?php

namespace App\Traits;

trait HttpResponses
{
    protected function succes($data,$message=null,$status_code=200): \Illuminate\Http\JsonResponse
    {

        return response()->json(
            [
                'status'=>'Request was succesful',
                'message'=>$message,
                'data'=>$data
            ],$status_code);
    }
    protected function wrong($data,$message=null,$status_code): \Illuminate\Http\JsonResponse
    {

        return response()->json(
            [
                'status'=>'An error has occurred',
                'message'=>$message,
                'data'=>$data
            ],$status_code);
    }

}
