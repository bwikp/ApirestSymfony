<?php

namespace App\Controller\Api;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;

class LoginController extends AbstractController
{
    // #[Route(path:'/api/login', name: 'api_login', methods:["POST"])]
    // public function apiLogin(User $user,SerializerInterface $Serializer, EntityManagerInterface $entityManager)
    // {        

    // }

    #[Route(path:'/api/user/', name: 'api_user_get', methods:['GET'])]
    public function getAllUser(SerializerInterface $Serializer,UserRepository $userRepo , EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepo->findAll();
        $jsonUser = $Serializer->serialize($user,"json");
        
        return new JsonResponse($jsonUser,Response::HTTP_OK,[],true);
    }
    #[Route(path:'/api/user', name: 'api_user_get', methods:['GET'])]
    public function getAllUser2(SerializerInterface $Serializer,UserRepository $userRepo , EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepo->findAll();
        $jsonUser = $Serializer->serialize($user,"json");
        
        return new JsonResponse($jsonUser,Response::HTTP_OK,[],true);
    }
}
