<?php


namespace App\Tests\Domain\Entity;


use App\Domain\Entity\Comment;
use App\Domain\Exception\EmptyCommentException;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{

    /** @test */
    public function aCommentCanBeCreated(){
        $comment = new Comment(1, 1, 'Random Comment');
        $this->assertInstanceOf(Comment::class, $comment);
    }

    /** @test */
    public function aCommentWithNullContentThrowsException()
    {
        $this->expectException(EmptyCommentException::class);
        $comment = new Comment(1, 1, '');

    }
}