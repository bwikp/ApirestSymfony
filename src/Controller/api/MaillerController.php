<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerInterface;


class MaillerController extends AbstractController
{
        #[Route(path:'/api/email', name: 'api_mailer', methods: ['POST','GET'])]
        public function sendEmail(MailerInterface $mailer,SerializerInterface $serializer,Request $request)
            {
                $email = (new Email())
            ->from('zilpa.michel@gmail.com')
            ->to('zilpa.michel@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
            $mailer->send($email);
            return new JsonResponse("successfuly  sent");
            }

}