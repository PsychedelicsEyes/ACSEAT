<?php

namespace App\Controller\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;                          
    }
 
    /**
     * @Route("/payement", name="app_pay")
     */
    public function cart(SessionInterface $session, ProductRepository $productRepository): Response
    {


        $this->addFlash('success', 'produit ajouté');

        return $this->redirectToRoute('app_menu');


    
        return $this->render('shop/pay.html.twig');
    }
}