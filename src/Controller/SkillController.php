<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillController extends AbstractController
{
    #[Route('/skill', name: 'skillsList')]
    public function index(SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->findBy([], ["id" => "ASC"]);
        return $this->render('skill/index.html.twig', [
            'skills' => $skills,
        ]);
    }
}
