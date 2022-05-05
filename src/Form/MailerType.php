<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailerType extends AbstractType
{
    public function buildForm(/*Card $nard,*/ FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('card', EntityType::class, [
            'class' =>Card::class,
            //'name' => Card::class->getName(),
            'choice_label' => 'name',
            'placeholder' => 'Choisissez la carte'
        ])
        ->add('Envoyer', SubmitType::class)
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
