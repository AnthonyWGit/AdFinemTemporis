<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SoftDeleteController extends AbstractController
{
    #[Route('/account/softdelete/confirm', name: 'app_soft_delete')]
    public function index(EntityManagerInterface $em): Response
    {
        $slugger = new AsciiSlugger();
        $newSlug = $slugger->slug("Deleted User")."-".bin2hex(random_bytes(5));
        $today = new \DateTime();
        // $filter = $em->getFilters()->enable('soft-deleteable'); 
        // $filter->enableForEntity('Entity\Player');
        $this->getUser()->setSlug($newSlug);
        $this->getUser()->setDeletedAt($today);
        $this->getUser()->setUsername(null);
        $this->getUser()->setEmail(null);
        $em->flush();
        return $this->redirectToRoute('app_logout');
        // return $this->render('soft_delete/index.html.twig', [
        //     'controller_name' => 'SoftDeleteController',
        // ]);
    }

    #[Route('/account/softdelete/warning', name: 'softDeleteWarning')]
    public function warning(EntityManagerInterface $em): Response
    {
        return $this->render('soft_delete/index.html.twig', [
            'controller_name' => 'SoftDeleteController',
        ]);
    }
}
