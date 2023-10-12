<?php

namespace App\Controller;

use App\Entity\DemonBase;
use App\Repository\DemonBaseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemonBaseController extends AbstractController
{
    #[Route('/demon/base', name: 'demonsList')]
    public function index(DemonBaseRepository $demonBaseRepository): Response
    {
        $demonsBases = $demonBaseRepository->findBy([], ["name" => "ASC"]);
        return $this->render('demon_base/index.html.twig', [
            'demons' => $demonsBases,
        ]);
    }
}
