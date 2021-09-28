<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/menu", name="menu")
     */
    public function shop(ProductRepository $productRepository): Response
    {
    
        return $this->render('shop/shop.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

    }

}