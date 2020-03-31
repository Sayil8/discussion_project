<?php


namespace App\Domain;


use App\Domain\Exception\ExistingUserException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Entity\User;
use App\Infrastructure\Response\UserResponse;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var UserRepositoryInterface
     */
    private $Doctrinerepository;

   public function __construct(UserRepository $userRepository,
                                UserPasswordEncoderInterface $passwordEncoder,
                                UserRepositoryInterface $Doctrinerepository)
    {

        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->Doctrinerepository = $Doctrinerepository;
    }


    public function createUser($data): JsonResponse
    {

        if(empty($data['email']) || empty($data['password'])){
            return UserResponse::getBadRequestResponse();
        }


        $email = $data['email'];
        $password = $data['password'];

        /** @var User $user */
        $user = $this->userRepository->findBy([
            'email' => $email
        ]);

        if(!empty($user)){
            throw new ExistingUserException();
        }

        $user = new User();

        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $this->Doctrinerepository->save($user);
        return UserResponse::getSuccessResponse($user);

    }

    public function getUser($data)
    {
        if(empty($data['email']))
            return UserResponse::getBadRequestResponse();

        $email = $data['email'];

        /** @var User $user */
        $user = $this->userRepository->findBy([
            'email' => $email
        ]);

        if(empty($user))
            return UserResponse::getNotFoundResponse('User does not exist');

        return UserResponse::getSuccessResponse($user);

    }

    public function getUsers()
    {
        $users = $this->Doctrinerepository->getUsers();

        if(empty($users))
            return UserResponse::getNotFoundResponse();

        return UserResponse::getSuccessResponse($users);
    }
}