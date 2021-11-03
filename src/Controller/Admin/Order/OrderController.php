<?php

namespace App\Controller\Admin\Order;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class OrderController extends AbstractController
{

    /**
     * @Route("/order/index", name="admin_display_order")
     */
    public function admin(OrderRepository $ordertRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'orders' => $ordertRepository->findAll(),
        ]);
      
    }

    
}