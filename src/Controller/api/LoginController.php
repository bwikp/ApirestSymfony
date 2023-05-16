<?php

namespace App\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class LoginController extends  AbstractController
{                          
    /**
     * @throws \JsonException
     */
    #[Route(path: '/api/login', name: 'api_login', methods: ["POST"])]

     public function ApiLogin()
    {
            $user = $this->getUser();

            $userData = [
                'email'=>$user->getEmail(),
                'first_name'=>$user->getFirstName(),
                'last_name'=>$user->getLastName(),

            ];
            return new JsonResponse(json_encode($userData, JSON_THROW_ON_ERROR));
    }
}