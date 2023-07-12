<?php

    namespace App\Controller\Api;

// use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\SecurtiryAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;    
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register',methods:["POST"])]
    public function register(ValidatorInterface $validator,SerializerInterface $serializer ,Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, SecurtiryAuthAuthenticator $authenticator, EntityManagerInterface $entityManager): JsonResponse
    {
        if($this->getUser())
            {
                return new JsonResponse($serializer->serialize(['message'=>'you must logout into get register page'],'json'),Response::HTTP_UNAUTHORIZED,[],true);
            }

            $newUser = $serializer->deserialize($request->getContent(),User::class,'json');

            $error = $validator->validate($newUser);

            if($error->count()>0)
                {
                    return new JsonResponse($serializer->serialize($error,'json'),Response::HTTP_BAD_REQUEST,[],true);
                }
                    
                $getPassWord = $newUser->getPassWord();

                        $newUser->setPassword(
                            $userPasswordHasher->hashPassword(
                                    $newUser
                                    ,$getPassWord
                                    
                            ),
                            $newUser->setRoles('["ROLE_USER"]')
                            );

            $entityManager->persist($newUser);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );
            // CONNECT AUTIMATIQUEMENT APRES CREATION
                return new JsonResponse($serializer->serialize(['message '=>'your account has been created'],'json'),Response::HTTP_OK,['accept'=>'application/json'],true);
    }
}
