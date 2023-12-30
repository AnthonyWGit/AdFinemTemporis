<?php

namespace App\Controller;

use App\Entity\SkillTable;
use App\Form\SkillTableFormType;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillTableController extends AbstractController
{
    #[Route('/admin/skillTable', name: 'skillTablesList')]
    public function index(SkillTableRepository $skillTableRepository): Response
    {
        //Difference from other tables : we want to group all the skill that a base demon can learn
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

    // #[Route('/skill/show/{name}', name: 'skillDetail')]
    // public function detail(Skill $skill): Response
    // {
    //     return $this->render('skill/detail.html.twig', [
    //         'skill' => $skill,
    //     ]);
    // }

    #[Route('admin/skillTable/new', name: 'newSkillTable')]
    #[Route('admin/skillTable/{id}/edit', name: 'editSkillTable')]
    public function new(SkillTable $skillTable = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($skillTable === null) {
            $skillTable = new SkillTable();
        }
        $form = $this->createForm(SkillTableFormType::class, $skillTable);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $skillTable = $form->getData();
                $entityManager->persist($skillTable); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('skillTablesList'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("skill_table/new.html.twig", ['formNewSkillTable' => $form, 'edit' => $skillTable->getId()]);
    }

    #[Route('admin/skillTable/{id}/delete', name: 'deleteSkillTable')]
    public function delete(SkillTable $skillTable, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($skillTable);
        $entityManager->flush();
        $this->addFlash(
            'noticeChange',
            'This entry has been deleted'
        );
        return $this->redirectToRoute('skillTablesList');
    }

}
