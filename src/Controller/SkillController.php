<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillFormType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/skill/show/{name}', name: 'skillDetail')]
    public function detail(Skill $skill): Response
    {
        return $this->render('skill/detail.html.twig', [
            'skill' => $skill,
        ]);
    }

    #[Route('admin/skill/new', name: 'newSkill')]
    #[Route('admin/skill/{name}/edit', name: 'editSkill')]
    public function new(Skill $skill = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($skill === null) {
            $skill = new Skill();
        }
        $form = $this->createForm(SkillFormType::class, $skill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $skill = $form->getData();
                $entityManager->persist($skill); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('skillsList'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("skill/new.html.twig", ['formNewSkill' => $form, 'edit' => $skill->getId()]);
    }

    #[Route('admin/skill/{name}/delete', name: 'deleteSkill')]
    public function demonTraitDelete(Skill $skill, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($skill);
        $entityManager->flush();
        $this->addFlash(
            'noticeChange',
            'This entry has been deleted'
        );
        return $this->redirectToRoute('skillsList');
    }

}
