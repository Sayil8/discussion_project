<?php


namespace App\Tests\Infrastructure;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommentEndPointTest extends WebTestCase
{
    /** @test */
    public function ACommentCanBePostedToTheDataBase(){
        $client = $this->createClient();

        $request = $client->request(
            'POST',
            'http://127.0.0.1:8000/api/comment/save',
            [
                'articleId' => 28,
                'userId' => 2,
                'content' => 'Random comment'
            ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('success', $client->getResponse()->getContent());
    }
    /** @test */
    public function ACommentCanBeErrasedFromDataStore(){
        $client = $this->createClient();

        $request = $client->request(
            'DELETE',
            'http://127.0.0.1:8000/api/comment/commentarticles/9');

        //var_dump($client->getResponse()->getContent());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}