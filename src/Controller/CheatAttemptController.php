<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheatAttemptController extends AbstractController
{
    #[Route('/cheat/attempt', name: 'cheating')]
    public function index(): Response
    {
        return $this->render('cheat_attempt/index.html.twig', [
            'controller_name' => 'CheatAttemptController',
        ]);
    }
}
