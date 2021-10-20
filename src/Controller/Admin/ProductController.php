<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\EditProductForm;
use App\Form\ProductForm;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
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
    private TokenGenerator  $tokenGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenGenerator  $tokenGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
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
                ->setCreatedAt(new \DateTimeImmutable())
                ->setProductId($this->tokenGenerator->generate());

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'produit ajouté');

            return $this->redirectToRoute('create_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView()
        ]);
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

            return $this->redirectToRoute('edit_product', [
                'productId' => $product->getProductId()
            ]);
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