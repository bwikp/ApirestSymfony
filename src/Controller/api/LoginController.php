<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\entity\User;
use App\Repository\UserRepository;

class LoginController extends AbstractController
{
    #[Route(path:'/api/login', name: 'api_login', methods:["POST"])]
    public function ApiLogin()
    {
        $user = $this->getUser();

        $userData = [
            'email'=>$user->getEmail(),
            'first_name'=>$user->getFirstName(),
            'last_name'=>$user->getLastName()
        ];

        return $this->json($userData);
    }

    #[Route(path:'/api/user/', name: 'api_user_get', methods:['GET'])]
    public function GetCategory(SerializerInterface $Serializer,UserRepository $userRepo , EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepo->findAll();
        $jsonUser = $Serializer->serialize($user,"json");
        
        return new JsonResponse($jsonUser,Response::HTTP_OK,[],true);
    }
}
