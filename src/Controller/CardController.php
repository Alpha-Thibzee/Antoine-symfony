<?php

namespace App\Controller;

use Exception;
use App\Entity\Card;
use App\Form\CardType;
use App\Form\FilterType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="homecard")
     */
    public function list(CardRepository $repo, Request $request): Response
    {
        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);
        $cards = $repo->findAll();

        if($filter->isSubmitted() && $filter->isValid()){
            $order = ($filter['price']->getData()? 'ASC' : 'DESC');
            $cards = $repo->filterCard($order);
        }

        return $this->render('card/list.html.twig', [
            'cards' => $cards,
            'filter' => $filter->createView()
        ]);
    }

    /**
     * @Route("/card/{id}", name="showcard")
     */
    public function show(CardRepository $repo, string $id): Response
    {
        $card = $repo->findOneBy(['id' => $id]);

        return $this->render('card/show.html.twig', [
            'card' => $card
        ]);
    }

    /**
     * @Route("/new-card", name="newcard")
     */
    public function new(EntityManagerInterface $em, Request $request, TranslatorInterface $translator): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($card);

            try{
                $em->flush();
                $this->addFlash('success', $translator->trans('article_creation_succes'));
            }catch(Exception $e){
                $this->addFlash('danger', 'Echec lors de la carte !');
                return $this->redirectToRoute('newcard');
            }

            return $this->redirectToRoute('homecard');

        }

        return $this->render('card/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modify-card/{id}", name="editcard")
     */
    public function edit(Card $card, Request $request, EntityManagerInterface $em): Response
    {
     
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            try{
                $em->flush();
                $this->addFlash('success', 'Carte modifiée !');

            }catch(Exception $e){
                $this->addFlash('danger', 'Echec lors de la modification de la carte !');
            }
            
            return $this->redirectToRoute('homecard');
        }


        return $this->render('card/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/delete-card/{id}", name="deletecard")
     */
    public function delete(Card $card, EntityManagerInterface $em): Response
    {
     
        $em->remove($card);
       
        try{
            $em->flush();
            $this->addFlash('success', 'Carte supprimée !');

        }catch(Exception $e){
            $this->addFlash('danger', 'Echec lors de la suppression de la carte !');
        }
        

        return $this->redirectToRoute('homecard');

    }
}
