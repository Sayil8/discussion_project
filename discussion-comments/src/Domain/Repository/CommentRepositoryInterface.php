<?php


namespace App\Domain\Repository;

use App\Domain\Entity\Comment;

interface CommentRepositoryInterface
{
    public function saveComment(Comment $comment);

    public function getComment(int $id);

    public function getCommentsArticle(int $idArticle);

    public function deleteCommentsArticle(int $idArticle);
}