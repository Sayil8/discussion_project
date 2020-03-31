<?php


namespace App\Tests\Infrastructure;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class Domain extends WebTestCase
{

    public function getAccessToken()
    {

        $client = HttpClient::create();
        $response = $client->request('POST', 'http://127.0.0.1:8000/api/login_check',[
            'json' => [
                'username' => 'user@user.com',
                'password' => '123'
            ]
        ]);
        $data = json_decode(
            $response->getContent(),
            true
        );
        //var_dump($data['token']);
        return $data['token'];
    }

    /** @test */
    public function getAllUsersWithToken()
    {

        $client = HttpClient::create();
        $token = $this->getAccessToken();
        $response = $client->request('GET', 'http://localhost/article-users/public/api/user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'json' => [
                'email' => 'user@user.com'
            ]
        ]);



        $data = json_decode($response->getContent(), true);
        $userInfo = $data['result'];
        var_dump($userInfo[0]['email']);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(201, $statusCode );

    }

    /** @test */
    public function getUserWithEmailAndToken()
    {
        $client = HttpClient::create();
        $token = $this->getAccessToken();
        $response = $client->request('GET', 'http://localhost/rest-api/public/api', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        //var_dump($response);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode );

        $data = json_decode($response->getContent(), true);
        //var_dump($data);
    }
}