<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{


    public function success($message, $data = null, $token = null, $code = 200, $id = null): JsonResponse
    {
        $response = [
            'message' => $message,
//          'success' => true,
        ];

        if ($data !== null) {
            if ($data instanceof LengthAwarePaginator) {
                // If data is a paginator instance, include pagination data
                $response['pagination'] = [
                    'total' => $data->total(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'next_page_url' => $data->nextPageUrl(),
                    'prev_page_url' => $data->previousPageUrl(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem()
                ];
                $response['data'] = $data->items();
            } else
                $response['data'] = $data;
        }

        if ($token !== null) {
            $response['token'] = $token;
        }

        if ($id !== null) {
            $response['id'] = $id;
        }

        return response()->json($response, $code);
    }

    public function notFound($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], 404);
    }

    public function validationError($message, $errors, $code = 422): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors'  => $errors,
            'success' => false,
        ], $code);
    }

    public function error($message, $code = 400): JsonResponse
    {
        return response()->json([
            'errors' => $message,
            'success' => false,
        ], $code);
    }


    public function serverError($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], 500);
    }

//    public function apiResponse($data = null, $message = null, $status = null)
//    {
//
//        $array = [
//            'message' => $message,
//            'status' => $status
//        ];
//
//        if ($data instanceof LengthAwarePaginator) {
//            // If data is a paginator instance, include pagination data
//            $array['pagination'] = [
//                'total' => $data->total(),
//                'per_page' => $data->perPage(),
//                'current_page' => $data->currentPage(),
//                'last_page' => $data->lastPage(),
//                'next_page_url' => $data->nextPageUrl(),
//                'prev_page_url' => $data->previousPageUrl(),
//                'from' => $data->firstItem(),
//                'to' => $data->lastItem()
//            ];
//            $array['data'] = $data->items();
//        } else {
//            // If data is not a paginator instance, include it as it is
//            $array['data'] = $data;
//        }
//
//        return response($array, $status);
//    }


}
