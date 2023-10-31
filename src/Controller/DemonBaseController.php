<?php

namespace App\Controller;

use App\Entity\DemonBase;
use App\Form\DemonBaseFormType;
use App\Repository\DemonBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemonBaseController extends AbstractController
{
    #[Route('/demon/base', name: 'demonsList')]
    public function index(DemonBaseRepository $demonBaseRepository): Response
    {
        $demonsBases = $demonBaseRepository->findBy([], ["id" => "ASC"]);
        return $this->render('demon_base/index.html.twig', [
            'demons' => $demonsBases,
        ]);
    }

    #[Route('/demon/base/show/{name}', name: 'demonDetail')]
    public function detail(DemonBase $demon, DemonBaseRepository $demonBaseRepository): Response
    {
        return $this->render('demon_base/detail.html.twig', [
            'demon' => $demon,
        ]);
    }

    #[Route('admin/demon/base/new', name: 'newDemonBase')]
    #[Route('admin/demon/base/{name}/edit', name: 'editDemonBase')]
    public function new(DemonBase $demonBase = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($demonBase === null) {
            $demonBase = new DemonBase();
        }
        $form = $this->createForm(DemonBaseFormType::class, $demonBase);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $demonBase = $form->getData();
                $entityManager->persist($demonBase); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('demonsList'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("demon_base/new.html.twig", ['formNewDemonBase' => $form, 'edit' => $demonBase->getId()]);
    }

    #[Route('admin/demon/base/{name}/delete', name: 'deleteDemonBase')]
    public function demonBaseDelete(DemonBase $demonBase, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($demonBase);
        $entityManager->flush();
        return $this->redirectToRoute('demonsList');
    }
}
