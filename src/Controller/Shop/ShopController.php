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
    
        $cart = $session->get("cart", []);

        $dataCart = [];
        $total = 0;
        $products = $productRepository->findAll();

        foreach($cart as $id => $quantite){
            $product = $productRepository->find($id);
            $dataCart[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }

        return $this->render('shop/shop.html.twig', compact("dataCart", "total", "products"));

    }


    /**
     * @Route("/menu/add/{productId}", name="add_cart")
     */
    public function add(SessionInterface $session, Product $product)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }


        $session->set("cart", $cart);

       return $this->redirectToRoute("app_menu");
    }

    /**
     * @Route("/menu/remove/{productId}", name="remove_cart")
     */
    public function remove(SessionInterface $session, Product $product)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            if($cart[$id] > 1){
            $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }

        $session->set("cart", $cart);

       return $this->redirectToRoute("app_menu");
    }

    /**
     * @Route("/menu/delete/{productId}", name="del_cart")
     */
    public function delete(SessionInterface $session, Product $product)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            unset($cart[$id]);
        
        }
        $session->set("cart", $cart);

       return $this->redirectToRoute("app_menu");
    }

    
    /**
     * @Route("/menu/deleteall", name="del__all_cart")
     */
    public function deleteAll(SessionInterface $session)
    {
       $session->remove("cart");

       return $this->redirectToRoute("app_menu");
    }
    

}