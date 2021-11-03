<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("", name="app_admin")
     */
    public function admin(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ): Response
    {
        return $this->render('admin/admin.html.twig', [
            'users' => $userRepository->findAll(),
            'products' => $productRepository->findAll(),
            'categories' => $categoryRepository->findAll()
        ]);
      
    }

    
}
