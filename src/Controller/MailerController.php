<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\MailerType;
use App\Repository\CardRepository;
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
    public function mailer(CardRepository $repo, Card $card, string $id, TransportInterface $mailer): Response
    {

        $repo = $repo->findOneBy(['id' => $id]);
        // $name = $card->getName();
        // $price = $card->getPrice();

        $email = (new TemplatedEmail())
        ->from('antoinerobert@example.com')
        ->to('antoinerobert43@example.com')
        ->subject('Proposition de prix')

        // path of the Twig template to render
       ->htmlTemplate('mailer/index.html.twig')

        // pass variables (name => value) to the template
        ->context([
            'card' => $card,
           
        ])
    ;

        $mailer->send($email);

        //return $this->render('mailer/index.html.twig', [
            //'card' => $card,
            //'price' => $price
            //'form' => $form->createView()
        //]);

        return $this->redirectToRoute('homecard');



    }
}