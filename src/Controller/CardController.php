<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="homecard")
     */
    public function list(CardRepository $repo): Response
    {
        $cards = $repo->findAll();
        return $this->render('card/list.html.twig', [
            'cards' => $cards,
        ]);
    }
}
