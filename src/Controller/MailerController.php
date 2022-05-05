<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\MailerType;
use App\Repository\CardRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer/{id}", name="app_mailer")
     */
    public function mailer(Request $request, CardRepository $repo, Card $card, string $id, TransportInterface $mailer): Response
    {
        $form = $this->createForm(MailerType::class);
        $form->handleRequest($request);
        $repo = $repo->findOneBy(['id' => $id]);
        $name = $card->getName();
        $price = $card->getPrice();

        if($form->isSubmitted() && $form->isValid()){
            //$form = $form->getData();
            //$price = $mailForm['price']->getData();
            
            $email = (new TemplatedEmail())
        ->from('antoinerobert@example.com')
        ->to('antoinerobert43@example.com')
        ->subject('Proposition de prix')
        ->text($form['message'])

        // path of the Twig template to render
       ->htmlTemplate('mailer/index.html.twig')
        // pass variables (name => value) to the template
        ->context([
            'card' => $card,
            //'form' => $form
            //'price' => $mailForm['price']
           
        ]);

            $mailer->send($email);

            return $this->redirectToRoute('homecard');
        }

        
       

        

        return $this->render('mailer/index.html.twig', [
            'form' => $form->createView(),
            'card' => $card,
            'price' => $price,
            'name' => $name
            
        ]);

        //return $this->redirectToRoute('homecard');



    }
}