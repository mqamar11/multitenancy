<?php

   function apiResponse(bool $success, string $message, $data = null,  $code = null)
    {
        $statusCode = is_int($code) ? $code : ($success ? 200 : 400);

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }
