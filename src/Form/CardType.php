<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un nom pour votre carte !'
                    ])
                ]
            ])
            ->add('example', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un nombre d\'exemplaire pour votre carte !'
                    ])
                ]
            ])
            ->add('price', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un prix pour votre carte !'
                    ])
                ]
            ])
            ->add('isOnSale', CheckboxType::class, [
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez une description pour votre carte !'
                    ])
                ]
            ])
            ->add('release_date')
            ->add('purchase_date')
            ->add('image', FileType::class, [
                'data_class' => null,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024K'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
