<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TheLabController extends AbstractController
{
    #[Route('/the_lab', name: 'the_lab')]
    public function index(SkillRepository $skillRepository, DemonTraitRepository $traitRepository, 
    DemonBaseRepository $demonBaseRepository, SkillTableRepository $skillTableRepository): Response
    {
        $skills = $skillRepository->findBy([], ["id" => "ASC"]);
        $traits = $traitRepository->findBy([], ["id" => "ASC"]);
        $demonsBase = $demonBaseRepository->findBy([], ["id" => "ASC"]);
        $skillsTable = $skillTableRepository->findBy([], ["id" => "ASC"]);
        return $this->render('the_lab/index.html.twig', [
            'controller_name' => 'TheLabController',
            'skills' => $skills,
            'traits' => $traits,
            'demonsBase' => $demonsBase,
            'skillsTable' => $skillsTable,
        ]);
    }
}
