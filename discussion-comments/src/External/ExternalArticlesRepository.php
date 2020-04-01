<?php


namespace App\External;


use Symfony\Component\HttpClient\HttpClient;

class ExternalArticlesRepository
{

    private $data = [];

    public static function getAllArticles():array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost/rest-api/public/api');
        $data = json_decode(
            $response->getContent(),
            true
        );
         return $data['result'];
    }
    public static function getArticleById(int $id): ?string
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost/rest-api/public/api/post/'.$id);

        if($response->getStatusCode() == 404){
            return null;
        }
        $data = json_decode(
            $response->getContent(),
            true
        );
        return $data['result']['id'];

    }
}