<?php

namespace App\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class LoginController extends  AbstractController
{                          
    /**
     * @throws \JsonException
     */
    #[Route(path: '/api/login', name: 'api_login', methods: ["POST"])]

     public function ApiLogin()
    {
            $user = $this->getUser();

            return new JsonResponse(json_encode("logged in",JSON_THROW_ON_ERROR));
    }
}