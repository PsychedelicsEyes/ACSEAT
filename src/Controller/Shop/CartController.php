<?php

namespace App\Controller\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route("/panier", name="app_cart")
     */
    public function cart(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get("cart", []);

        $dataCart = [];
        $total = 0;

        foreach($cart as $id => $quantite){
            $product = $productRepository->find($id);
            $dataCart[] = [
                "product" => $product,
                "quantite" => $quantite
            ];


            $total += $product->getPrice() * $quantite;

            $session->set('total', $total);
            
        }




        return $this->render('shop/cart.html.twig', compact("dataCart", "total"));
    }

    /**
     * @Route("/panier/add/{id}", name="add_cart")
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

       return $this->redirectToRoute("app_cart");
    }

    /**
     * @Route("/panier/remove/{id}", name="remove_cart")
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

       return $this->redirectToRoute("app_cart");
    }

    /**
     * @Route("/panier/delete/{id}", name="del_cart")
     */
    public function delete(SessionInterface $session, Product $product)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            unset($cart[$id]);
        
        }
        $session->set("cart", $cart);

       return $this->redirectToRoute("app_cart");
    }

    
    /**
     * @Route("/panier/deleteall", name="del__all_cart")
     */
    public function deleteAll(SessionInterface $session)
    {
       $session->remove("cart");

       return $this->redirectToRoute("app_cart");
    }
    

}