<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\EditCategoryForm;
use App\Form\CategoryForm;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class CategoryController extends AbstractController
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
     * @Route("/category/index", name="display_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {

        return $this->render('admin/category/index.html.twig', [
            'categorys' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/category/new", name="create_category")
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category->setCategoryId($this->tokenGenerator->generate());
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'category ajouté');

            return $this->redirectToRoute('display_category');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }




    /**
     * @Route("/category/edit/{id}", name="edit_category")
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(EditCategoryform::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'catégorie modifié');

            return $this->redirectToRoute('display_category', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    
    /**
     * @Route("/category/del/{id}", name="del_category")
     */
    public function del(Category $category): RedirectResponse
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
        $this->addFlash('success', 'OK');
        return $this->redirectToRoute('display_category');
        
    }


}