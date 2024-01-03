<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use App\Repository\SuggestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewsController extends AbstractController
{
    #[Route('/reviews', name: 'app_reviews')]
    public function index(SuggestionRepository $suggestionRepository, PlayerRepository $playerRepository): Response
    {
        $newSuggestions = 0;
        $suggestions = $suggestionRepository->findSuggestionsOrderedByLikes();
        foreach ($suggestions as $suggestion) 
        {
            if ($suggestion->isNew()) $newSuggestions = $newSuggestions + 1;
        }
        return $this->render('community/index.html.twig', [
            'suggestions' => $suggestions,
            'newSuggestions' => $newSuggestions,
        ]);
    }
}
