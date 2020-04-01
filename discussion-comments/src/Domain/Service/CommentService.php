<?php


namespace App\Domain\Service;


use App\Domain\Entity\Comment;
use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Repository\ArticleRepositoryInterface;
use App\Domain\Repository\CommentRepositoryInterface;
use App\Repository\DoctrineCommentRepository;

class CommentService
{

    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(CommentRepositoryInterface $commentRepository,
                                ArticleRepositoryInterface $articleRepository)
    {

        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
    }

    public function saveComment(Comment $comment)
    {
        $idArticle = $this->articleRepository->find($comment->getArticleId());
        if(!$idArticle){
            throw new ArticleNotFoundException();
        }

        $this->commentRepository->saveComment($comment);

        return array_merge(['message' => 'success'], $comment->jsonSerialize());
    }

    public function getCommentOfArticle(int $idArticle)
    {
        return $this->commentRepository->getCommentsArticle($idArticle);
    }

    public function deleteCommentOfArticle(int $idArticle)
    {
        $this->commentRepository->deleteCommentsArticle($idArticle);
        return ['message' => 'comments deleted successfully'];
    }
}