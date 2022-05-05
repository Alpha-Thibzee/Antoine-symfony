<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\MailerType;
use Symfony\Component\Mime\Email;
use App\Repository\CardRepository;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer/{id}", name="sendmail")
     */
    public function mailer(CardRepository $repo, string $id,  MailerInterface $mailer): Response
    {   
        
        $repo = $repo->findOneBy(['id' => $id]);
        $name = $repo->getName();
      
        $email = (new TemplatedEmail())
        ->from('antoinerobert@example.com')
        ->to('antoinerobert43@example.com')
        ->subject('Commande de machin envoyé !')

        // path of the Twig template to render
      // ->htmlTemplate('mailer/index.html.twig')

        // pass variables (name => value) to the template
        ->context([
            'name' => $name
        ])
    ;

        $mailer->send($email);

        return $this->render('mailer/index.html.twig',);
      

        //return $this->redirectToRoute('homecard');


        
    }
}

