<?php

namespace App\Controller;

use App\Entity\DemonTrait;
use App\Form\DemonTraitFormType;
use App\Repository\DemonTraitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/trait/show/{name}', name: 'traitDetail')]
    public function detail(DemonTrait $demonTrait): Response
    {
        return $this->render('trait/detail.html.twig', [
            'demonTrait' => $demonTrait,
        ]);
    }

    #[Route('admin/trait/new', name: 'newTrait')]
    #[Route('admin/trait/{name}/edit', name: 'editTrait')]
    public function new(DemonTrait $demonTrait = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($demonTrait === null) {
            $demonTrait = new DemonTrait();
        }
        $form = $this->createForm(DemonTraitFormType::class, $demonTrait);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $demonTrait = $form->getData();
                $entityManager->persist($demonTrait); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('traitsList'); //redirect to list traits if everything is ok
            }
        
        return $this->render("trait/new.html.twig", ['formNewDemonTrait' => $form, 'edit' => $demonTrait->getId()]);
    }

    #[Route('admin/trait/{name}/delete', name: 'deleteDemonTrait')]
    public function demonTraitDelete(DemonTrait $demonTrait, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($demonTrait);
        $entityManager->flush();
        $this->addFlash(
            'noticeChange',
            'This entry has been deleted'
        );
        return $this->redirectToRoute('traitsList');
    }
}
