<?php


namespace App\Controller;


use App\Domain\Entity\Comment;
use App\Domain\Service\CommentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController
{

    /**
     * @var CommentService
     */
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function storeComment(Request $request){

        $data = json_decode(
            $request->getContent(),
        true);

        $comment = new Comment(
            $data['articleId'],
            $data['userId'],
            $data['content']
        );
        return new JsonResponse($this->commentService->saveComment($comment) ,Response::HTTP_OK);
    }

    public function getCommentinArticle(int $articleId){
        return new JsonResponse($this->commentService->getCommentOfArticle($articleId), Response::HTTP_OK);
    }

    public function deleteCommentInArticle(int $articleId)
    {
        return new JsonResponse($this->commentService->deleteCommentOfArticle($articleId), Response::HTTP_OK);
    }
}