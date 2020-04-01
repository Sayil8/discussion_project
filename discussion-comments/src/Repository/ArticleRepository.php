<?php


namespace App\Repository;


use App\Domain\Repository\ArticleRepositoryInterface;
use App\External\ExternalArticlesRepository;

class ArticleRepository implements ArticleRepositoryInterface
{

    public function find(int $id): string
    {
        if(!ExternalArticlesRepository::getArticleById($id))
            return null;
        else
            return 'sucess';
    }
}