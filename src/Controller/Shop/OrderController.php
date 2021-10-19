<?php

namespace App\Controller\Shop;

use App\Security\TokenGenerator;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenGenerator  $tokenGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @Route("/payement", name="app_pay")
     */
    public function cart(SessionInterface $session,ProductRepository $productRepository,OrderRepository $orderRepository): Response
    {
        $cart = $session->get("panier", []);

        $dataCart = [];
        $total = 0;
        $totalQuantite = 0;

        foreach($cart as $id => $quantite){
            $product = $productRepository->find($id);
            $dataCart[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
            $totalQuantite += $quantite;
        }


        $order = new Order();

        $order
        ->setCreatedAt(new \DateTimeImmutable())
        ->setQuantiteProduct($totalQuantite) 
        ->setAmountTotal($total);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->addFlash('success', 'produit ajouté');
        return $this->redirectToRoute('app_menu');
        return $this->render("shop/pay.html.twig");
    }
}