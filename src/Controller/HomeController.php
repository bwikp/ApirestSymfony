<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\user;
use App\Repository\LibraryRepository;
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(UserRepository $userRepository,LibraryRepository $libraryRepository): Response
    {
        // $user = $userRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'lib' =>$libraryRepository->findAll(),
            'user' =>$userRepository->findAll()
        ]);
    }
}
