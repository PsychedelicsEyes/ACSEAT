<?php

namespace App\Controller\Shop;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/menu", name="app_menu")
     */
    public function shop(SessionInterface $session,ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        

        return $this->render('shop/shop.html.twig', [
            'products' => $productRepository->findAll(),
        ]);

    }

}