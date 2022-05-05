<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MailerType extends AbstractType
{
    public function buildForm(/*Card $nard,*/ FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('price', IntegerType::class, [
               
            'label' => 'Votre proposition de prix concernant la carte',
            'attr' => ['min' => ""],
        ])
        ->add('message', TextType::class, [
               
            'label' => 'Votre message', 
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
