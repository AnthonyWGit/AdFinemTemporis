<?php

namespace App\Controller;

use App\Entity\DemonBase;
use App\Entity\DemonTrait;
use App\Entity\DemonPlayer;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{

    // #[Route('/get-mp3-data', name: 'get_mp3_data')]
    // public function getMp3Data(): Response
    // {
    //     $mp3FilePath = realpath($this->getParameter('kernel.project_dir') . '/public/sfx/typewriter.mp3');
    //     $data = ['mp3FilePath' => $mp3FilePath];
    //     return new JsonResponse($data);
    // }

    #[Route('/game', name: 'game')]
    public function index(): Response
    {
        if ($this->getUser()->getStage() == 0)
        {
            return $this->render('game/index.html.twig', [
                'controller_name' => 'GameController',
            ]);           
        }
        else if ($this->getUser()->getStage() == 1)
        {
            $demonchoice = $this->getUser()->getDemonPlayer();
            foreach ($demonchoice as $demon)
            {
                $demon = $demon;
            }
            return $this->render('game/stageOne.html.twig', [
                'demon' => $demon,
            ]);    
        }
        else
        {

        }
    }

    #[Route('/game/choice/{name}', name: 'choice', requirements : ['name' =>  '\w+'])]
    public function choiceHorus(string $name, DemonBaseRepository $demonBaseRepository, DemonTraitRepository $demonTraitRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getStage() == 0 && $name == 'Horus')
        {
            $horus = $this->pickDemonBase($demonBaseRepository, 'horus');
            $horusTrait = $this->traitGen($demonTraitRepository);
            $demonPlayer = new DemonPlayer; //create a demon
            $demonPlayer->setDemonBase($horus); //set base template
            $demonPlayer->setTrait($horusTrait); //generate a trait
            $this->getUser()->addDemonPlayer($demonPlayer);
            $this->getUser()->setStage(1);
            $entityManager->persist($demonPlayer);
            $entityManager->flush();
            return $this->redirectToRoute("game");
        }   
        else
        {
            return $this->redirectToRoute('app_home');
        }
    }

    public function traitGen(DemonTraitRepository $demonTraitRepository) : DemonTrait
    {
        $traits = $demonTraitRepository->findBy([], ["name" => "ASC"]); 
        $randomSetTraits = [];
        foreach ($traits as $trait)
        {
            $randomSetTraits[] = $trait;
        }
        $pickedTrait = array_rand($randomSetTraits);
        return $randomSetTraits[$pickedTrait];
    }

    public function pickDemonBase(DemonBaseRepository $demonBaseRepository, string $demonName) : DemonBase
    {
        $horus = $demonBaseRepository->findOneBy(["name" => "Horus"]);
        return $horus;
    }
}
