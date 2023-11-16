<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'user_profile', methods: ["GET"])]
    public function index(UserInterface $user): Response
    {
        return $this->json($user);
    }
}
