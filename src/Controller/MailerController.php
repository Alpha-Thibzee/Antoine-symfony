<?php

namespace App\Controller;


use App\Entity\Card;
use App\Form\MailerType;
use App\Form\MailFormType;
use App\Repository\CardRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer/{id}', name: 'mailer')]
    public function index(CardRepository $card , Card $cards ,Request $request, TransportInterface $mailer, $id)
    {
        $card->findOneBy(['id' => $id]);
        $value = $cards->getPrice()+1;
        $name = $cards->getName();
        $form = $this->createForm(MailerType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new TemplatedEmail())
                ->from('test@test.Fr')
                ->to('alexis@carte-collection.com')
                ->subject('Nouvelle propositon d\'achat pour la carte '.$name.' d\'une valeur de '. $contactFormData['value'].'€')
                ->text(
                    $contactFormData['message'],
                    'text/plain')
                ->context([
                    'message' => $contactFormData["message"]
                ]);

                    try {
                        $mailer->send($message);
                        $this->addFlash('success', 'Votre proposition d\'offre pour la carte "'.$name.'" à bien été envoyé');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash('error', 'Votre proposition d\'offre pour la carte "'.$name.'" n\'a pas été envoyé');
                        return $this->redirectToRoute('homepage');
                    }


            return $this->redirectToRoute('homecard');
        }
        
        return $this->render('mailer/index.html.twig', [
            'name' => $name,
            'value' => $value,
            'form' => $form->createView()
        ]);
    }
    
}
