<?php

namespace App\Controller;

use App\Entity\Suggestion;
use App\Form\SuggestionType;
use App\Repository\SuggestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommunityController extends AbstractController
{
    #[Route('/community', name: 'community')]
    public function index(SuggestionRepository $suggestionRepository): Response
    {
        $suggestions = $suggestionRepository->findBy([], ["postDate" => "ASC"]);
        return $this->render('community/index.html.twig', [
            'suggestions' => $suggestions,
        ]);
    }

    #[Route('community/suggestion/new', name: 'newSuggestion')]
    #[Route('cummunity/suggestion/{id}/edit', name: 'editSuggestion')]
    public function new(Suggestion $suggestion = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!is_null($this->getUser()->getSend()))
        {
            $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
            (
                'notice',
                'You already have made a suggestion !'
            );
            return $this->redirectToRoute('community');
        }
        // creates a task object and initializes some data for this example
        if ($suggestion === null) {
            $suggestion = new Suggestion();
        }

        $form = $this->createForm(SuggestionType::class, $suggestion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {

                $date = new \DateTime();
                $suggestion->setPostDate($date);
                $this->getUser()->setSend($suggestion);
                $entityManager->persist($suggestion); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('community'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("community/new.html.twig", ['formNewSuggestion' => $form, 'edit' => $suggestion->getId()]);
    }

}
