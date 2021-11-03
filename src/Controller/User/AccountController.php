<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/compte", name="account")
     */
    public function account(UserRepository $userRepository): Response
    {
        
        return $this->render('account/account.html.twig', [
            'users' => $userRepository->findAll(),
        ]);

    }

}