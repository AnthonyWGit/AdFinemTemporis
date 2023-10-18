<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Battle;
use App\Entity\DemonBase;
use App\Entity\DemonTrait;
use App\Entity\DemonPlayer;
use App\Repository\SkillRepository;
use App\Repository\PlayerRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
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


    #[Route('/endpoint', name: 'endpoint')]
    public function checkSignal(Request $request) {
        $output = $request->request->get('A');
        $session = $request->getSession();
        $session->set('placeholder','a');
        return new Response($output);
    }

    #[Route('/test/sessionReset', name: 'sessionReset')]
    public function reset(Request $request) {
        $session = $request->getSession();
        $session->clear();
        return $this->redirectToRoute("app_home");
    }

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

    #[Route('/game/combat', name: 'combat')]
    public function combat(Request $request, ?Battle $battle, ?DemonBaseRepository $demonBaseRepository, ?SkillTableRepository $skillRepository ,?DemonTraitRepository $demonTraitRepository, PlayerRepository $playerRepository, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if ($session->get('placeholder') == 'a' )
        {
            $battle = new Battle;
            $playerDemons = $this->getUser()->getDemonPlayer();
            $playerDemon = $playerDemons[0];
            $generatedCpu = $this->cpuDemonGen('imp', $demonBaseRepository, $skillRepository , $demonTraitRepository,$playerRepository, $entityManager);
            // $playerDemons[0]->addFighter($battle);
            // $generatedCpu->addFighter2($battle);
            $playerDemon->addFighter($battle);
            $playerDemon->addFighter2($battle);
            $entityManager->persist($battle);
            $entityManager->flush();
            return $this->render('game/combat.html.twig', [
                'cpuDemon' => $generatedCpu,
                'playerDemons' => $playerDemons
            ]);    
        }
        else
        {
            dd("not ok");
        }

        return $this->redirectToRoute("app_home");
    }


    #[Route('/game/choice/{name}', name: 'choice', requirements : ['name' =>  '\w+'])]
    public function choiceHorus(string $name, SkillRepository $skillRepository, SkillTableRepository $skillTableRepository,
    DemonBaseRepository $demonBaseRepository, DemonTraitRepository $demonTraitRepository,
    EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getStage() == 0 && $name == 'Horus')
        {
            $horus = $this->pickDemonBase($demonBaseRepository, 'horus');
            $horusTrait = $this->traitGen($demonTraitRepository);
            $demonPlayer = new DemonPlayer; //create a demon
            $skills = $skillTableRepository->findBy(["level" => 1, "demonBase" => $horus->getId()],["id" => "ASC"]);
            $skill = $skills[0]; //level on will only have on skill
            $skill = $skill->getSkill();
            $demonPlayer->setDemonBase($horus); //set base template
            $demonPlayer->setTrait($horusTrait); //generate a trait
            $demonPlayer->addSkill($skill);
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
        $pickedTrait = array_rand($traits);
        return $traits[$pickedTrait];
    }

    public function pickDemonBase(DemonBaseRepository $demonBaseRepository, string $demonName) : DemonBase
    {
        $demon = $demonBaseRepository->findOneBy(["name" => $demonName]);
        return $demon;
    }

    public function pickOneSkill(SkillRepository $skillRepo, string $skillName) : Skill
    {
        $skill = $skillRepository->findOneBy(["name" => $skillName]);
        return $skill;
    }

    public function pickAllLearnableSkills(SkillTableRepository $skillTableRepository, int $demonId)
    {
        $skills = $skillTableRepository->findBy(["demonBase" => $demonId], ["id" => "ASC"]);
        return $skills;
    }

    
    public function cpuDemonGen(string $string, ?DemonBaseRepository $demonBaseRepository, ?SkillTableRepository $skillRepo ,?DemonTraitRepository $demonTraitRepository, ?PlayerRepository $playerRepository, ?EntityManagerInterface $entityManager) : DemonPlayer
    {
        $trait = $this->traitGen($demonTraitRepository);
        $imp = $this->pickDemonBase($demonBaseRepository, 'imp');
        $cpu = $playerRepository->findOneBy(["username" => "CPU"]);
        $skillsTable = $this->pickAllLearnableSkills($skillRepo, $imp->getId());
        if (count($skillsTable) > 6)
        {
            $randSetOfSkills = array_rand($skills, 6);
            $skills = $skills[$randSetOfSkills];
        }
        $demonPlayer = new DemonPlayer; //create a demon
        $demonPlayer->setDemonBase($imp); //set base template
        $demonPlayer->setTrait($trait); //generate a trait
        foreach ($skillsTable as $skillTable) //it gives the id in the skill table but so we need to getskill
        {
            $skill = $skillTable->getSkill();
            $demonPlayer->addSkill($skill);
        }
        $cpu->addDemonPlayer($demonPlayer);

        $entityManager->persist($demonPlayer);
        $entityManager->flush();
        return $demonPlayer;
    }
}
