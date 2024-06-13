<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController {

    #[Route("/", name:"home")]
    function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, Security $security) : Response {

        return $this->render('home/index.html.twig');
   }
}
