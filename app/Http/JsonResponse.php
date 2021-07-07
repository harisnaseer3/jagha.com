<?php

namespace App\Http;

use Response;
use \Symfony\Component\HttpFoundation\JsonResponse as LaravelJsonResponse;

class JsonResponse extends LaravelJsonResponse
{
    //Success
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;

    //Client Errors
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const INVALID_METHOD = 405;
    const UNPROCESSABLE = 422;

    //Server Error
    const ERROR = 500;

    /**
     * @param null $data
     * @param null $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message = null, $data = null, $status_code = null)
    {
        if ($status_code === null) {
            $status_code = self::OK;
        }

        if ($data === null) {
            $data = (object)$data;
        }

        return response()->json([
            'status' => 'success',
            'status_code' => $status_code,
            'data' => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param $errors
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($errors, $status_code = self::ERROR)
    {
        if ($errors === null) {
            $errors = ['The service has encountered an error.'];
        }
        if (!is_array($errors)) {
            $errors = [$errors];
        }

        return response()->json([
            'status' => 'error',
            'status_code' => $status_code,
            "data" => null,
            "message" => $errors
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function created()
    {
        return $this->success(null, self::CREATED);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function successNoContent()
    {
        return $this->success(null, null);
//        return $this->success(null, self::NO_CONTENT);
    }

    /**
     * @param null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequest($errors = null)
    {
        return $this->failed($errors, self::BAD_REQUEST);
    }

    /**
     * @param string $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorized($errors = 'This account must authenticate before making this request.')
    {
        return $this->failed($errors, self::UNAUTHORIZED);
    }

    /**
     * @param string $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidden($errors = 'This user is not authorized to access this account or feature.')
    {
        return $this->failed($errors, self::FORBIDDEN);
    }

    /**
     * @param string $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($errors = 'User does not exists')
    {
        return $this->failed($errors, self::NOT_FOUND);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function resourceNotFound()
    {
        return $this->failed('The resource you are trying to access does not exist.', self::BAD_REQUEST);
    }

    /**
     * @param string $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidMethod($errors = 'This HTTP method is not valid for this route.')
    {
        return $this->failed($errors, self::INVALID_METHOD);
    }

    /**
     * @param string $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function unprocessable($errors = 'The service was unable to process the request parameters.')
    {
        return $this->failed($errors, self::UNPROCESSABLE);
    }
}
