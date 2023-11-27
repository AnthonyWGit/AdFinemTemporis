<?php

namespace App\Controller;

use App\Entity\SkillTable;
use App\Repository\SkillTableRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillTableController extends AbstractController
{
    #[Route('/admin/skillTable', name: 'skillTablesList')]
    public function index(SkillTableRepository $skillTableRepository): Response
    {
        $skillTables = $skillTableRepository->findBy([], ["demonBase" => "ASC"]);
        $groupedSkillTables = [];
        foreach ($skillTables as $skillTable) {
            $groupedSkillTables[$skillTable->getDemonBase()->getId()][] = $skillTable;
        }
        return $this->render('skill_table/index.html.twig', [
            'groupedSkillTables' => $groupedSkillTables,
            'skillTables' => $skillTables,
        ]); 
    }
}
