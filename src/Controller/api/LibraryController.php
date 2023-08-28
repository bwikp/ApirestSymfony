<?php

namespace App\Controller\Api;

use App\Repository\LibraryRepository;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Library;

class LibraryController extends AbstractController
{
    #[Route('/api/lib', name: 'app_lib_read', methods: ['GET'])]
    public function getlibAll(SerializerInterface $Serializer, LibraryRepository $libraryRepository, EntityManagerInterface $entityManager):JsonResponse
        {
            $books = $libraryRepository->findAll();
            $jsonLib = $Serializer->serialize($books,"json");

             return new JsonResponse($jsonLib,Response::HTTP_OK,[],true);
        }


    #[Route('/api/lib/new/{id}', name:'app_lib_new',methods:['POST'])]
    public function postNewLivre($id,ValidatorInterface $validator,UserRepository $userRepository ,SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager):JsonResponse
        {
            $lib = $serializer->deserialize($request->getContent(), Library::class, "json");

            $error = $validator->validate($lib);

        if ($error->count() > 0) {
            return new JsonResponse($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $user = $userRepository->find($id);

        // $user->getId();

        //git check;
        $lib->setUser($user);

        $entityManager->persist($lib);
        $entityManager->flush();

        return new JsonResponse("sucessfuly added");
        }
    #[Route('/api/lib/delete/{id}/{idlivre}', name: 'app_lib_delete', methods:['DELETE'])]
    public function libDelete($id,$idlivre,LibraryRepository $libraryRepository,EntityManagerInterface $entityManager): Response
        {   
            $livreX = $libraryRepository->findOneBy(
                ['user_id'=>$id],
                ['idlivre'=>$idlivre] 
            );
            $entityManager->remove($livreX);
            $entityManager->flush();

            return new JsonResponse(" the book has been deleted");
        }
        
}