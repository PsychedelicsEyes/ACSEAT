<?php

namespace App\Controller\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
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
    public function shop(SessionInterface $session,ProductRepository $productRepository): Response
    {
    
        $cart = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;
        $Allproducts = $productRepository->findAll();

        $products = [];
        foreach($Allproducts as $product) {
            $products[$product->getCategory()->getName()][] = $product;
        }

        foreach($cart as $id => $quantite){
            $product = $productRepository->find($id);
            $dataPanier[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }

        return $this->render('shop/shop.html.twig', compact("dataPanier", "total", "products"));

    }

}