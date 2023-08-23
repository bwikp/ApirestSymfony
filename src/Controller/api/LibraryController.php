<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LibraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Library;

class libController extends AbstractController
{
    #[Route('/api/lib', name: 'app_lib_read')]
    public function getlibAll(SerializerInterface $Serializer, LibraryRepository $libraryRepository, EntityManagerInterface $entityManager):JsonResponse
        {
            $books = $libraryRepository->findAll();
            $jsonLib = $Serializer->serialize($books,"json");

             return new JsonResponse($jsonLib,Response::HTTP_OK,[],true);
        }

}