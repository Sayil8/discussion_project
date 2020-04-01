<?php


namespace App\Tests\Infrastructure;


use App\Domain\Entity\Comment;
use PHPUnit\Framework\TestCase;

class CommentIsStored extends TestCase
{

    public function setUp(): void
    {

    }

    /** @test */
    public function aCommentIsStoredInDB()
    {
        $id = 1;
        $comment = new Comment($id, 1, 'some comment');
        $this->articleRepository->expects($this->once())->method('findArticle')->with($id)->willReturn(1);
        $this->commentRepository->expects($this->once())
            ->method(saveComment)
            ->with(1);
        $this->assertEquals('success', $this->commenRepository->saveComment($comment));
    }
}