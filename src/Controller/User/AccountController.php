<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/compte", name="account")
     */
    public function account(): Response
    {
        // TODO: Ici tu récuperes les informations de l'utilisateur
        return $this->render('account/account.html.twig');

    }

}