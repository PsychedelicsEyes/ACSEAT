<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre du produit'
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description du produit'
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix du produit'
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'label' => 'Category',
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('imageFile', FileType::class)
        ;
    }
}