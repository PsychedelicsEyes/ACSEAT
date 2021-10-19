<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/compte", name="app_account")
     */
    public function account(): Response
    {
        // TODO: Ici tu récuperes les informations de l'utilisateur
        return $this->render('account/account.html.twig');

    }

    /**
     *  @Route("/commande", name="app_order")
     */
    public function order(SessionInterface  $session): Response
    {
        // TODO: Faire l'historiquie de s commandes
        return $this->render('shop/order.html.twig');
    }
}