<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="app_mailer")
     */
    public function mailer(MailerInterface $mailer, Security $security): Response
    {   
        $user = $security->getUser();
        $username = $user->getName();
        $userMail = $user->getUserIdentifier();
        $email = (new TemplatedEmail())
    ->from('antoinerobert@example.com')
    ->to('antoinerobert43@example.com')
    ->subject('Commande de machin envoyé !')
    //->text('Nous vous avons envoyé vos machin aujourd\'hui ! Ils devrait arriver demain ! Merci !')

    // path of the Twig template to render
    ->htmlTemplate('mailer/index.html.twig')

    // pass variables (name => value) to the template
    ->context([
        'username' => $username,
        'userEmail' => $userMail
    ])
;

        $mailer->send($email);

        return$this->redirectToRoute('homepage');

        
    }
}

