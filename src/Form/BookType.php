<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
            ->add('author', EntityType::class, [
                'label' => 'Auteur du livre',
                'class' => Author::class,
                'placeholder' => 'Choisissez un auteur',
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix'
            ])
            ->add('genre', TextType::class, ['label' => 'Genre du livre'])
            ->add('publisher', EntityType::class, [
                'label' => 'Editeur du livre',
                'class' => Publisher::class,
                'choice_label' => 'name'
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Résumé du livre',
                'attr'  => ['rows' => '8']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr'  => [ 'class' => 'btn btn-block btn-primary']
            ])
        ;

        $builder->get('price')->addModelTransformer(new CallbackTransformer(
            function ($price){
                return (int) str_replace(".", ",", $price);
            },
            function ($price){
                return (int) str_replace(",", ".", $price);
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
