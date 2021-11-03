<?php

namespace App\Controller\Shop;

use App\Entity\Order;
use App\Entity\OrderProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function cart(Request $request,SessionInterface $session, ProductRepository $productRepository): Response
    {

        $cart = $session->get("cart", []);
        $total = $session->get("total", []);
 
        $products = Array();
        $user = $this->getUser();


        $order = new Order();
        $order
        ->setUser($user)
        ->setPrice($total)
        ->setReference(uniqid(" ", false))
        ->setCreatedAt(new \DateTimeImmutable());

        

        foreach($cart as $id=>$quantite){

            $product = $productRepository->findOneBy(['id' => $id]);

            $orderProduct = new orderProduct();
            $orderProduct->setQuantity($quantite);
            $orderProduct->setProduct($product);
            $this->entityManager->persist($orderProduct);
            $order->addOrderProduct($orderProduct);
            $this->entityManager->persist($order);
            
           $products[] =  [ 
             
               $quantite
            ];
        
            
        }
        $this->entityManager->flush();



        
        return $this->redirectToRoute('app_menu');

        return $this->render('shop/pay.html.twig');
    }
}