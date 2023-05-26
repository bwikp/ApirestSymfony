<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Category;

class CategorieController extends AbstractController
{
    #[Route(path:'/api/categorie/new', name: 'api_categorie_add', methods:['POST'])]
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

        return new JsonResponse("sucessfuly added");
    }

    #[Route(path:'/api/categorie/{id}/delete', name:'api_categorie_delete', methods:['DELETE'])]

    public function delCategory(SerializerInterface $Serializer,Category $categorie,EntityManagerInterface $entityManager):Response
        {
           $entityManager->remove($categorie);
           $entityManager->flush();

           return $this->json("sucessfuly delete");
        }
    
    #[Route(path:'/api/categorie/{id}/delete', name:'api_categorie_delete', methods:['DELETE'])]

    public function editCategory():Response
        {
            return $this->json("succesfuly edited");
        }

}
