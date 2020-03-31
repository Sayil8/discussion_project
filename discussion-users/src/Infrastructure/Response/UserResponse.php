<?php


namespace App\Infrastructure\Response;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserResponse
{
    public static function getSuccessResponse($data){
        return new JsonResponse(array(
            'message' => 'success',
            'result' => $data
        ), Response::HTTP_CREATED);
    }

    public static function getNotFoundResponse($message){
        return new JsonResponse(array(
            'message' => $message
        ), Response::HTTP_NOT_FOUND);
    }

    public static function getBadRequestResponse(){
        return new JsonResponse(array(
            'message' => 'Data was not recived in a proper way'
        ), Response::HTTP_BAD_REQUEST);
    }

    public static function getExceptionResponse($exception): JsonResponse
    {
        return new JsonResponse(array(
            'message' => $exception
        ), 406);
    }

}