<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\EditProductForm;
use App\Form\ProductForm;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class ProductController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/product/index", name="display_product")
     */
    public function index(ProductRepository $productRepository): Response
    {


        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }


    /**
     * @Route("/product/new", name="create_product")
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product
                ->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'produit ajouté');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/product/new.html.twig', 
        array('form' => $form->createView()));
    }


    /**
     * @Route("/product/edit/{id}", name="edit_product")
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(EditProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'produit modifié');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/del/{id}", name="del_product")
     */
    public function del(Product $product): RedirectResponse
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        $this->addFlash('success', 'OK');
        return $this->redirectToRoute('app_admin');
        
    }



}