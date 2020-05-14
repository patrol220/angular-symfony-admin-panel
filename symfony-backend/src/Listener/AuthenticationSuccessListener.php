<?php

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener
{
    private $tokenTtl;
    private $cookieName;

    public function __construct($tokenTtl, $cookieName)
    {
        $this->tokenTtl = $tokenTtl;
        $this->cookieName = $cookieName;
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();

        $token = $data['token'];

        $expire = (new \DateTime())->add(new \DateInterval('PT' . $this->tokenTtl . 'S'));

        /** @todo rethink and make it in right way */
        $response->headers->setCookie(
            new Cookie(
                $this->cookieName,
                $token,
                $expire,
                '/',
                null,
                null,
                true,
                false,
                'none'
            )
        );
    }
}
