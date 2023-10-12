<?php

namespace App\Controller;

use App\Repository\DemonTraitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraitController extends AbstractController
{
    #[Route('/trait', name: 'traitsList')]
    public function index(DemonTraitRepository $demonTraitRepository): Response
    {
        $traits = $demonTraitRepository->findBy([], ["id" => "ASC"]);
        return $this->render('trait/index.html.twig', [
            'traits' => $traits,
        ]);
    }
}
