<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use JMS\SerializerBundle\Annotation\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
class UserController extends AbstractController
{
    #[Route('/api/userAll', name: 'app_user_read', methods: ['GET'])]
    public function getUserRead(SerializerInterface $Serializer, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->findAll();
        $jsonUser = $Serializer->serialize($user, "json");

        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }


    #[Route('/api/user/{id}', name: 'app_user_read1', methods: ['GET'])]
    public function getUserReadOne($id, SerializerInterface $Serializer, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $oneUser = $userRepository->find($id);
        $oneUser->setPassword('');
        $oneUser->setRoles('');
        $jsonUser = $Serializer->serialize($oneUser, "json");
        // dd($oneUser);
        // $jsonUser-
        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{mail}', name: 'app_user_read33', methods: ['GET'])]
    public function getUserReadMail($mail, SerializerInterface $Serializer, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $oneUser = $userRepository->findBy(['email' => $mail]);
        $jsonUser = $Serializer->serialize($oneUser, "json");

        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }

   

    #[Route('/api/user/{id}/update', name: 'app_user_edit', methods: ['PUT'])]
    public function UpdaterUser($id, SerializerInterface $Serializer, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $user = $Serializer->deserialize($request->getContent(), User::class, "json");
        $userOne = $userRepository->find($id);
        // dd($userOne);
        $userOne->setEmail($user->getEmail());
        $userOne->setPassword($userPasswordHasher->hashPassword($userOne, $user->getPassword()));
        $userOne->setFirstName($user->getFirstName());
        $userOne->setLastName($user->getLastName());
        $entityManager->flush();
        $userOne = $Serializer->serialize($userOne, "json");
        return new JsonResponse($userOne, Response::HTTP_OK, [], true);
    }
    #[Route('/api/user/{id}/admin', name: 'app_user_admin', methods: ['PUT'])]
    public function userAdmin($id, SerializerInterface $Serializer, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        // $user = $Serializer->deserialize($request->getContent(), User::class, "json");
        $userOne = $userRepository->find($id);
        $userOne->becomeAdmin();
        $entityManager->flush();
        $userOne = $Serializer->serialize($userOne, "json");
        return new JsonResponse($userOne, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/{id}/nlAdmin', name: 'app_user_nladmin', methods: ['PUT'])]
    public function userRetro($id, SerializerInterface $Serializer, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        // $user = $Serializer->deserialize($request->getContent(), User::class, "json");
        $userOne = $userRepository->find($id);
        $userOne->setRoles('["ROLE_USER"]');
        $entityManager->flush();
        $userOne = $Serializer->serialize($userOne, "json");
        return new JsonResponse($userOne, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/{id}/delete', name: 'app_user_del', methods: ['DELETE'])]
    public function delUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(" User successfuly deleted ");
    }
}
