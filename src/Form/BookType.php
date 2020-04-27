<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre du livre', 'required' => true])
            ->add('author', TextType::class, ['label' => 'Auteur du livre'])
            ->add('publishedAt', DateType::class, ['label' => 'Date de publication', 'widget' => 'single_text'])
            ->add('price', NumberType::class, ['label' => 'Prix'])
            ->add('genre', TextType::class, ['label' => 'Genre du livre'])
            ->add('publisher', TextType::class, ['label' => 'Editeur du livre'])
            ->add('text', TextareaType::class, [
                'label' => 'Résumé du livre',
                'attr'  => ['rows' => '8']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr'  => [ 'class' => 'btn btn-block btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
