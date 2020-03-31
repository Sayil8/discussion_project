<?php


namespace App\Infrastructure;


use App\Domain\Exception\ExistingUserException;
use App\Domain\UserService;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Response\UserResponse;

class RegisterController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registerUser(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        //$headers = $request->headers->get('token');
        try{
            //return new JsonResponse(['headers' => $headers]);
            return ($this->userService->createUser($data));
        }catch (ExistingUserException $e){
            return UserResponse::getExceptionResponse($e);
        }


    }

    public function getUserWithEmail(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        return $this->userService->getUser($data);
    }

    public function getAllUsers(Request $request)
    {
        return $this->userService->getUsers();
    }

}