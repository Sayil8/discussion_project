<?php


namespace App\Domain\Repository;


interface ArticleRepositoryInterface
{

    public function find(int $id): string ;
}