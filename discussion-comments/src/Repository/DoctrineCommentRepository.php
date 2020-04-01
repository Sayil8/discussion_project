<?php


namespace App\Repository;


use App\Domain\Entity\Comment;
use App\Domain\Repository\CommentRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCommentRepository implements CommentRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveComment(Comment $comment)
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    public function getComment(int $id)
    {
        $this->entityManager->getRepository(Comment::class)->find($id);
    }

    public function getCommentsArticle(int $idArticle)
    {
       return $this->entityManager->getRepository(Comment::class)->findBy(['articleId' => $idArticle]);
    }

    public function deleteCommentsArticle(int $idArticle)
    {
        $data = $this->entityManager->getRepository(Comment::class)->findBy(['articleId' => $idArticle]);
        foreach ($data as $entity){
            $this->entityManager->remove($entity);
        }
        $this->entityManager->flush();
    }
}