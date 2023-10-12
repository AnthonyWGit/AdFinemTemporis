<?php

namespace App\Controller;

use App\Repository\SuggestionRepository;
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

}
