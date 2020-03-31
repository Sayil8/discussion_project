<?php


namespace App\Listeners;


use Composer\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenListener implements EventSubscriberInterface
{
    private $ttl;
    private $secure = false;

    public function __construct($ttl)
    {
        $this->ttl = $ttl;
    }

    public function setRefreshToken(\Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent $event)
    {
        $refreshToken = $event->getData()['refresh_token'];
        $response = $event->getResponse();

        if($refreshToken)
        {
            $response->headers->setCookie(
                new Cookie( 'REFRESH_TOKEN' , $refreshToken,
                    (new \DateTime())
                        ->add(new \DateInterval('PT'.$this->ttl.'S'))
                ), '/', null, $this->secure
            );
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => [
                ['setRefreshToken']
            ]
        ];
    }
}