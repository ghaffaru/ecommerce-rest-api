<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/register','register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $email = json_decode($request->getContent(), true)['email'];

        $password = json_decode($request->getContent(), true)['password'];

        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getEmail()));
    }

    #[Route('api')]
    public function api()
    {

    }
}
