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
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productRepository->find($id);
            $dataPanier[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }


        return $this->render('shop/cart.html.twig', compact("dataPanier", "total"));
    }

    /**
     * @Route("/panier/add/{id}", name="add_cart")
     */
    public function add(SessionInterface $session, Product $product)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }


        $session->set("panier", $panier);

       return $this->redirectToRoute("app_cart");
    }

    /**
     * @Route("/panier/remove/{id}", name="remove_cart")
     */
    public function remove(SessionInterface $session, Product $product)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
            $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

       return $this->redirectToRoute("app_cart");
    }

    /**
     * @Route("/panier/delete/{id}", name="del_cart")
     */
    public function delete(SessionInterface $session, Product $product)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        
        }
        $session->set("panier", $panier);

       return $this->redirectToRoute("app_cart");
    }

    
    /**
     * @Route("/panier/deleteall", name="del__all_cart")
     */
    public function deleteAll(SessionInterface $session)
    {
       $session->remove("panier");

       return $this->redirectToRoute("app_cart");
    }
    


}