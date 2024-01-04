<?php

namespace App\Controller;

use App\Entity\Suggestion;
use App\Repository\PlayerRepository;
use App\Repository\SuggestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewsController extends AbstractController
{
    #[Route('/reviews', name: 'reviews')]
    public function index(SuggestionRepository $suggestionRepository, PlayerRepository $playerRepository): Response
    {
        $newSuggestions = 0;
        $suggestions = $suggestionRepository->findBy([],["is_verified" => "DESC"]);
        foreach ($suggestions as $suggestion) 
        {
            if ($suggestion->isNew()) $newSuggestions = $newSuggestions + 1;
        }
        return $this->render('reviews/index.html.twig', [
            'suggestions' => $suggestions,
            'newSuggestions' => $newSuggestions,
        ]);
    }

    #[Route('/reviews/accept/{id}', name: 'acceptSuggestion')]
    public function accept(Suggestion $suggestion, EntityManagerInterface $em): Response
    {
        $suggestion->setIsVerified('0');
        $em->flush();
        $this->addFlash('notice','You have verified this suggestion');
        return $this->redirectToRoute('reviews');
    }

    #[Route('/reviews/deny/{id}', name: 'denySuggestion')]
    public function deny(Suggestion $suggestion, EntityManagerInterface $em): Response
    {
        $suggestion->setIsVerified('1');
        $em->flush();
        $this->addFlash('notice','You have denied this suggestion');
        return $this->redirectToRoute('reviews');
    }

    #[Route('/reviews/deny/{id}', name: 'deleteSuggestionAdmin')]
    public function erase(Suggestion $suggestion, EntityManagerInterface $em): Response
    {
        $em->remove($suggestion);
        $this->addFlash('notice','You have deleted this suggestion');
        return $this->redirectToRoute('reviews');
    }
}
