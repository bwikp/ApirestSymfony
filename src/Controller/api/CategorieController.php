<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;

class CategorieController extends AbstractController
{  
    #[Route(path: '/api/categorie/new', name: 'api_categorie_add', methods: ['POST'])]
    public function addCategory(ValidatorInterface $validator, SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $category = $serializer->deserialize($request->getContent(), Category::class, "json");

        $error = $validator->validate($category);

        if ($error->count() > 0) {
            return new JsonResponse($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse("sucessfuly added");
    }

    #[Route(path:'/api/categorie/{id}/update', name: 'api_categorie_update', methods: ['PUT'])]

    public function updateCategory($id,SerializerInterface $Serializer, CategoryRepository $categorieRepo, EntityManagerInterface $entityManager,Request $request):JsonResponse
    {
         $category = $Serializer->deserialize($request->getContent(), Category::class, "json");
         $categoryOne = $categorieRepo->find($id);
         $categoryOne->setName($category->getName());
         $entityManager->flush();
         $categoryOne = $Serializer->serialize($categoryOne,"json");
         return new JsonResponse($categoryOne, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/categorie/{id}/delete', name: 'api_categorie_delete', methods: ['DELETE'])]

    public function delCategory($id,CategoryRepository $categoryRepository ,EntityManagerInterface $entityManager): Response
    {
        $categorie = $categoryRepository->find($id);
        $entityManager->remove($categorie);
        $entityManager->flush();

        return new JsonResponse("successfuly  deleted");
    }

    #[Route(path: '/api/categorie', name: 'api_categorie_read', methods: ['GET'])]

    public function GetCategory(SerializerInterface $Serializer, CategoryRepository $categorieRepo, EntityManagerInterface $entityManager): JsonResponse
    {
        $categories = $categorieRepo->findAll();

        $jsonCategories = $Serializer->serialize($categories, "json");

        return new JsonResponse($jsonCategories, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/categorie/{id}', name: 'api_categorie_read1', methods: ['GET'])]
    public function getOneCategory($id,SerializerInterface $Serializer, CategoryRepository $categorieRepo, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $categoryOne = $categorieRepo->find($id);
        $categoryOne = $Serializer->serialize($categoryOne,"json");
        return new JsonResponse($categoryOne,Response::HTTP_OK,[],true);
    }
}