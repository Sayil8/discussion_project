<?php


namespace App\Domain\Entity;


use App\Domain\Exception\EmptyCommentException;

class Comment implements \JsonSerializable
{
    /** @var int */
    private $id;
    /**
     * @var int
     */
    private $articleId;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $content;

    public function __construct(int $articleId, int $userId, string $content)
    {
        $this->articleId = $articleId;
        $this->userId = $userId;
        $this->setConten($content);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function setConten(string $content)
    {
        if(empty($content))
            throw new EmptyCommentException();
        $this->content = $content;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'articleId' => $this->getArticleId(),
            'userId' => $this->getUserId(),
            'content' => $this->getContent()
        ];
    }
}