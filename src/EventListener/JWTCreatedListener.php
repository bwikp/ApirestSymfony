<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    private $security;
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        // In case you need to access user data on db
        // $user = $this->security->getUser();
        // checking a user property be like : $user->isIsValidated() ...

        // Here just checking if '_remember_me' is a valid property of the json request
        $jsonRequest = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $hasRememberMe = property_exists($jsonRequest,'_remember_me') ? true : false;
        
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['id'] = $user->getId();

        $event->setData($payload);
        
        if ($hasRememberMe){
            $expiration = new \DateTime('+1 month');
            $expiration->setTime(2, 0, 0);
            $payload        = $event->getData();
            $payload['exp'] = $expiration->getTimestamp();
            $event->setData($payload);
        }
        
    }  
}