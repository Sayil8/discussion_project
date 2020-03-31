<?php


namespace App\Tests\Infrastructure;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class ApiLogin  extends WebTestCase
{

    /** @test */

    public function aNewUserCanBeRegistert()
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://127.0.0.1:8000/register',[
            'json' => [
                'email' => 'user12@user.com',
                'password' => '123'
            ]
        ]);

        //var_dump($response);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(201, $statusCode );
    }

    /** @test */
    public function loginTokenAndRefreshToken(){

        $client = HttpClient::create();
        $response = $client->request('POST', 'http://127.0.0.1:8000/api/login_check',[
            'json' => [
                'username' => 'user1@user.com',
                'password' => '123'
            ]
        ]);

        $data = json_decode(
            $response->getContent(),
            true
        );
        //var_dump($data['token']);
        //var_dump($data);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode );

        //refresh the token
        $response = $client->request('POST', 'http://localhost/article-users/public/api/token/refresh',[
            'json' => [
                'refresh_token' => $data['refresh_token']
            ]
        ]);


        $data= json_decode($response->getContent(), true);
        var_dump($data);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
    }
}