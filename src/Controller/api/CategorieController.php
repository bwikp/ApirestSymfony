<?php

namespace App\Controller\Api;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategorieController extends AbstractController
{
    #[Route('/api/categorie/new', name: 'api_categorie_add', methods:['POST'])]
    public function addCategory(ValidatorInterface $validator,SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager):JsonResponse
    {
        $category = $serializer->deserialize($request->getContent(),Category::class,"json");

        $error = $validator->validate($category);
 
        if($error->count()>0)
                {
                    return new JsonResponse($serializer->serialize($error,'json'),Response::HTTP_BAD_REQUEST,[],true);
                }

        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse("ok");
    }
}
