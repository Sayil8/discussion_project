<?php


namespace App\Listeners;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{

    private $tokenTTL;
    private $secure = false;

    public function __construct($tokenTTL)
    {
        $this->tokenTTL = $tokenTTL;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {


        $response = $event->getResponse();
        $data = $event->getData();

        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }

        /*
        $data['data'] = array(
            'roles' => $user->getRoles(),
            'id' => $user->getId()
        );
        */

        $token = $data['token'];
        //unset($data['token']);
        $event->setData($data);

        $response->headers->setCookie(
            new Cookie( 'BEARER' , $token,
                (new \DateTime())
                    ->add(new \DateInterval('PT'.$this->tokenTTL.'S'))
                ), '/', null, $this->secure
        );



    }
}