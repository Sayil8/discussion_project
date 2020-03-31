<?php


namespace App\Infrastructure\Repository;


use App\Domain\Repository\UserRepositoryInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUsersRepository implements UserRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getUsers()
    {
       return $this->entityManager->getRepository(User::class)->findAll();
    }
}