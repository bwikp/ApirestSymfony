<?php

namespace App\Controller\Api;


use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    #[Route(path: '/api/contact/new/{id}', name:'app_contact_post', methods: ['POST'])]
    public function newContact($id,ValidatorInterface $validator,UserRepository $userRepository, SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager):jsonResponse
       {
           $contact = $serializer->deserialize($request->getContent(), Contact::class,'json');
           $error = $validator->validate($contact);

           if ($error->count() > 0) {
               return new JsonResponse($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, [], true);
           }
           
           $user = $userRepository->find($id);
           $contact->setUser($user);
           $entityManager->persist($contact);
           $entityManager->flush();
   
           return new JsonResponse("sucessfuly added");
       }

       #[Route(path: '/api/contact/update/{id}',name: 'app_contact_update', methods:['PUT'])]
        public function updateContact($id,SerializerInterface $Serializer, ContactRepository $contacteRepo, EntityManagerInterface $entityManager,Request $request):jsonResponse
         {
            $contact = $Serializer->deserialize($request->getContent(), Contact::class, "json");
            $contactOne = $contacteRepo->find($id);
            $contactOne->setGithub($contact->getGithub());
            $contactOne->setTwitter($contact->getTwitter());
            $contactOne->setLinkedin($contact->getLinkedin());
            $entityManager->flush();
            $contactOne = $Serializer->serialize($contactOne,"json");
                // return new JsonResponse($contactOne,Response::HTTP_OK,[],true);
                return new JsonResponse('Change has been made');        
         }
        #[Route(path: '/api/contact/{id}', name: 'app_contact_read', methods: ['GET'])]
        public function getContact($id,SerializerInterface $Serializer, ContactRepository $contactRepo, EntityManagerInterface $entityManager, Request $request):jsonResponse    
        {
            $contactOne = $contactRepo->find($id);
            $contactOne->setUser(NULL);
            $contactOne = $Serializer->serialize($contactOne,"json");
            return new JsonResponse($contactOne,Response::HTTP_OK,[],true);
        }
}

    
