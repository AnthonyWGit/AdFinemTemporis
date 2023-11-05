<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Battle;
use App\Entity\DemonBase;
use App\Entity\DemonTrait;
use App\Entity\DemonPlayer;
use App\Repository\SkillRepository;
use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemonPlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class GameController extends AbstractController
{

    // #[Route('/get-mp3-data', name: 'get_mp3_data')]
    // public function getMp3Data(): Response
    // {
    //     $mp3FilePath = realpath($this->getParameter('kernel.project_dir') . '/public/sfx/typewriter.mp3');
    //     $data = ['mp3FilePath' => $mp3FilePath];
    //     return new JsonResponse($data);
    // }


    #[Route('/ajaxe/setStage/{stage}', name: 'setStage')]
    public function setStage(string $stage, Request $request, EntityManagerInterface $em) 
    {
        $this->getUser()->setStage($stage);
        $em->flush();
        return new Response();
    }

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
    public function index(Request $request, PlayerRepository $playerRepository, BattleRepository $battleRepository): Response
    {
        if ($this->inBattleCheck($request, $playerRepository, $battleRepository)) return $this->redirectToRoute('combat');
        // if ($this->isGranted("ROLE_IN_COMBAT")) return $this->redirectToRoute("combat");

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
        else if ($this->getUser()->getStage() == 9999)
        {
            return $this->redirectToRoute("hub");
        }
        else
        {
            return $this->redirectToRoute("app_home");
        }
    }

    #[Route('/ajaxe/combatAjax', name: 'combatAjax')]
    public function combatAjax(Request $request, ?Battle $battle, 
    ?DemonBaseRepository $demonBaseRepository, ?SkillTableRepository $skillRepository ,
    ?DemonTraitRepository $demonTraitRepository, PlayerRepository $playerRepository, 
    ?BattleRepository $battleRepository, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
{

    // This is an AJAX request
    // Prepare your data here. This could be an object, an array, etc.
    // For example, let's use the same data you were passing to the Twig template:
    $idPLayer = $this->getUser()->getDemonPlayer();
    $idPLayer = $idPLayer[0];
    $battleContent = $battleRepository->findOneBy(["demonPlayer1" => $idPLayer]);
    $playerDemons = $this->getUser()->getDemonPlayer();
    $playerDemon = $playerDemons[0];
    $generatedCpu = $battleContent->getDemonPlayer2();
    $xpEarned = $battleContent->getXpEarned();
    $goldEarned = $battleContent->getGoldEarned();
    if ($request->request->get("isCombatResolved") == "Yes")
    {
        if ($request->request->get("Winner") == $this->getUser()->getUsername())
        {
            $request->getSession()->set("isCombatResolved" , 'Yes');
            $request->getSession()->set("Winner" , $this->getUser()->getUsername());
            $data =
                [
                    'button' => 'endCombat'
                ];
            return new JsonResponse;
        }
    }

    if ($playerDemon->getTotalAgi() > $generatedCpu->getTotalAgi())
    {
        $initiative = $this->getUser()->getUsername();
    }
    else if($playerDemon->getTotalAgi() < $generatedCpu->getTotalAgi())
    {
        $initiative = 'CPU';
    }
    else
    {
    }
    // Prepare the data to return as JSON
    $data = [
        'xpEarned' =>$xpEarned,
        'goldEarned' =>$goldEarned,
        'cpuDemon' => [
            'id' => $generatedCpu->getId(),
            'hpMax' =>$generatedCpu->getMaxHp(),
            'name' => $generatedCpu->getDemonBase()->getName(),
            'skills' => array_map(function ($skill) 
            {
                return $skill->getName(); // adjust this based on your Skill entity structure
            }, $generatedCpu->getSkills()->toArray())
            
            // add other fields as needed
        ],
        'playerDemons' => array_map(function($demon) {
            return [
                'id' => $demon->getId(),
                'hpMax' =>$demon->getMaxHp(),
                'name' => $demon->getDemonBase()->getName(),
                'skills' => array_map(function ($skill) {
                    return $skill->getName(); // adjust this based on your Skill entity structure
                }, $demon->getSkills()->toArray())
                // add other fields as needed
            ];
        }, $playerDemons->toArray()),
        'initiative' => [
            'initiative' => $initiative
        ],
        'playersNames' => [
            'player1' => $this->getUser()->getUsername(),
            'player2' => 'CPU'
        ]
    ];
    
    // Return the data as a JSON response
    return new JsonResponse($data);
    
}

    #[Route('/game/ajaxe/SkillUsed', name: 'SkillUsedAjax')]
    public function skillUsed(Request $request, SkillRepository $skillRepository, DemonPlayerRepository $demonPlayerRepository, PlayerRepository $playerRepository): Response
    {
        $turn = $request->request->get('turn');
        if ($turn == "Player1")
        {
            $currentCPUHp = $request->request->get('hpCurrentCPU');
            $skillUsed = $request->request->get('skill');
            $demonPlayerId = $request->request->get('demonPlayer1Id');
            $cpuDemonId = $request->request->get('demonPlayer2Id');
            // $demonPlayerId = 118;
            // $cpuDemonId = 119;
            $skillObj = $skillRepository->findOneBy(["name" => $skillUsed]);
            $demonPlayerObj = $demonPlayerRepository->findOneBy(["id" => $demonPlayerId]);
            $demonCPUObj = $demonPlayerRepository->findOneBy(["id" => $cpuDemonId]);
            $dmgDone = $skillObj->dmgCalc($demonPlayerObj, $demonCPUObj);
            // $dmgDone = 1;
            $data = 
            [
                'dmg' => $dmgDone,
            ];
            return new JsonResponse($data);
        }
        else
        {
            $currentCPUHp = $request->request->get('hpCurrentCPU');
            $skillUsed = $request->request->get('skill');
            $demonPlayerId = $request->request->get('demonPlayer1Id');
            $cpuDemonId = $request->request->get('demonPlayer2Id');
            // $demonPlayerId = 118;
            // $cpuDemonId = 119;
            $skillObj = $skillRepository->findOneBy(["name" => $skillUsed]);
            $demonPlayerObj = $demonPlayerRepository->findOneBy(["id" => $demonPlayerId]);
            $demonCPUObj = $demonPlayerRepository->findOneBy(["id" => $cpuDemonId]);
            $dmgDone = $skillObj->dmgCalc($demonCPUObj, $demonPlayerObj);

            // $dmgDone = 1;
            $data = 
            [
                'dmg' => $dmgDone,
            ];

            return new JsonResponse($data);
        }

    }

    #[Route('/game/combat/resolve', name: 'combatResolve')]
    public function combatResolve(Request $request, ?Battle $battle, ?DemonPlayerRepository $demonPlayerRepository,
    ?DemonBaseRepository $demonBaseRepository, ?SkillTableRepository $skillTableRepository ,
    ?DemonTraitRepository $demonTraitRepository, PlayerRepository $playerRepository, 
    ?BattleRepository $battleRepository, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
    {
        $session = $request->getSession();
        
        if ($session->get('isCombatResolved')) 
        {
            if ($session->get('Winner') == $this->getUser()->getUsername())
            {
                // $session->getFlashBag()->clear();
                $playerDemons = $this->getUser()->getDemonPlayer();
                $allDemons = $this->getUser()->getDemonPlayer();
                // Store each demon's level before the XP addition
                $levelsBefore = [];
                foreach ($allDemons as $demonBefore) 
                {
                    $levelsBefore[$demonBefore->getId()] = $demonBefore->getLevel();
                }
                $playerDemon = $playerDemons[0];
                $battle = $battleRepository->findOneBy(["demonPlayer1" => $playerDemon]);
                $generatedCpu = $battle->getDemonPlayer2();
                $currentGold = $this->getUser()->getGold();
                $currentXp = $playerDemon->getExperience();
                $goldEarned = $battle->getGoldEarned();
                $xpEarned =  $battle->getXpEarned();
                $totalXp = $xpEarned + $currentXp;
                $totalGold = $goldEarned + $currentGold;
                $this->getUser()->setGold($totalGold);
                $playerDemon->setExperience($totalXp);
                // Add XP and store each demon's level after the XP addition
                $levelsAfter = [];
                foreach ($playerDemons as $demonAfter) {
                    // Add XP to $demonAfter here...

                    $levelsAfter[$demonAfter->getId()] = $demonAfter->getLevel();
                }
                $entityManager->remove($battle);
                $entityManager->remove($generatedCpu);
                $entityManager->flush();
                if (($this->getUser()->getStage() < 3 && $session->get("isCombatResolved") == "Yes"))
                {
                    $this->getUser()->setStage(2);
                    $entityManager->flush();
                }
                $session->remove('Winner');
                $session->remove("isCombatResolved");

                foreach ($playerDemons as $demon)
                {
                    $demonLevel = $demon->getLevel();
                    $learnableSkill =  $skillTableRepository->findOneBy(["level" => $demonLevel, "demonBase" => $demon->getDemonBase()->getId()]);
                    if ($learnableSkill !== null)
                    {
                        $skill = $learnableSkill->getSkill(); 
                        $demon->addSkill($skill);
                        $this->addFlash(
                            'notice',
                            'One of your Demon gained a new skill !'
                        );
                        $entityManager->persist($demon);
                        $entityManager->flush();
                    }
                }
                // Compare each demon's level before and after the XP addition
                foreach ($levelsBefore as $id => $levelBefore) {
                    if ($levelBefore != $levelsAfter[$id]) {
                        $demonPlayerRepository->findOneBy(["id" => strval($id)])->addLvlUpPoints($levelsAfter[$id] - $levelBefore); //points gained are difference level after - level be4
                        $entityManager->flush();
                        $strId = (strval($id));
                        $this->addFlash(
                            'noticeLevel',
                            $demonPlayerRepository->findOneBy(["id" => strval($id)])->getDemonBase()->getName() .' gained a level !');
                        $this->addFlash(
                            'noticeLevel',
                            $demonPlayerRepository->findOneBy(["id" => strval($id)])->getDemonBase()->getName(). ' gained a lvlUp point !'
                        );
                    }
                }
                if ($this->getUser()->getStage() == 9999) return $this->redirectToRoute("hub");
                return $this->redirectToRoute("stageTwo");
            }  
        }
    }
          
        

    #[Route('/game/stageTwo', name: 'stageTwo')]
    public function stageTwo(Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em, BattleRepository $battleRepository, SkillTableRepository $skillTableRepository)
    {
        $starter = $this->getUser()->getDemonPlayer();
        $session = $request->getSession();
        if ($this->inBattleCheck($request, $playerRepository, $battleRepository)) return $this->redirectToRoute('combat');
        if ($this->getUser()->getStage() != 2) 
        {
            return $this->redirectToRoute("app_home");
        }
        return $this->render('game/stageTwo.html.twig', [
            'demon' => $starter[0],
            'demons' => $starter,
        ]);
    }

    #[Route('/game/hub', name: 'hub')]
    public function hub(Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em, BattleRepository $battleRepository, SkillTableRepository $skillTableRepository)
    {
        $starter = $this->getUser()->getDemonPlayer();
        $session = $request->getSession();
        if ($this->inBattleCheck($request, $playerRepository, $battleRepository)) return $this->redirectToRoute('combat');
        if ($this->getUser()->getStage() != 9999) 
        {
            return $this->redirectToRoute("app_home");
        }
        return $this->render('game/hub.html.twig', [
            'demons' => $demons,
        ]);
    }

    #[Route('/game/combat', name: 'combat')]
    public function combat(Request $request, ?Battle $battle, 
    ?DemonBaseRepository $demonBaseRepository, ?SkillTableRepository $skillRepository ,
    ?DemonTraitRepository $demonTraitRepository, PlayerRepository $playerRepository, 
    ?BattleRepository $battleRepository, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
    {
        if ($this->inBattleCheck($request, $playerRepository, $battleRepository)) $inBattle = true; else $inBattle =false;

        $session = $request->getSession();
        if ($session->get('placeholder') == 'a' && /*!$this->isGranted('ROLE_IN_COMBAT')*/ !$inBattle || ($this->getUser()->getStage() == 9999 && !$inBattle))  //Condition to start a new combat
        {
            $session->remove('placeholder');
            $cpu = $playerRepository->findOneBy(["username" => "CPU"]);
            $battle = new Battle;
            $battle->setXpEarned(600);
            $battle->setGoldEarned(30);
            $playerDemons = $this->getUser()->getDemonPlayer();
            $generatedCpu = $this->cpuDemonGen('imp', $demonBaseRepository, $skillRepository , $demonTraitRepository,$playerRepository, $entityManager);
            // $playerDemons[0]->addFighter($battle);
            // $generatedCpu->addFighter2($battle);
            $playerDemon = $playerDemons[0];
            $playerDemon->addFighter($battle);
            $generatedCpu->addFighter2($battle);
            $entityManager->persist($battle);
            // $this->getUser()->addRole("ROLE_IN_COMBAT");
            // $token = new UsernamePasswordToken($this->getUser(), null, 'main', $this->getUser()->getRoles());
            // $this->get('security.token_storage')->setToken($token);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
            if ($playerDemon->getTotalAgi() > $generatedCpu->getTotalAgi())
            {
                $initiative = $this->getUser()->getUsername();
            }
            else if($playerDemon->getTotalAgi() < $generatedCpu->getTotalAgi())
            {
                $initiative = 'CPU';
            }
            else
            {
                $initiative = rand($initiative = $this->getUser()->getUsername() , 'CPU');
            }
            $session->set('playerDemonLevel', $playerDemon->getLevel());
            return $this->render('game/combat.html.twig', [
                'cpuDemon' => $generatedCpu,
                'playerDemons' => $playerDemons,
                'intiative' => $initiative
            ]);    
        }
        else if (/*$this->isGranted('ROLE_IN_COMBAT')*/ $inBattle) //combat is still in progress so the user is put in it 
        {
            $idPLayer = $this->getUser()->getDemonPlayer();
            $idPLayer = $idPLayer[0];
            $battleContent = $battleRepository->findOneBy(["demonPlayer1" => $idPLayer]);
            $playerDemons = $this->getUser()->getDemonPlayer();
            $playerDemon = $playerDemons[0];
            $generatedCpu = $battleContent->getDemonPlayer2();
            if ($playerDemon->getTotalAgi() > $generatedCpu->getTotalAgi())
            {
                $initiative = $this->getUser()->getUsername();
            }
            else if($playerDemon->getTotalAgi() < $generatedCpu->getTotalAgi())
            {
                $initiative = 'CPU';
            }
            else
            {
            }
            return $this->render('game/combat.html.twig', [
                'cpuDemon' => $generatedCpu,
                'playerDemons' => $playerDemons,
                'initiative' => $initiative
            ]);    
        }
        else if ($this->getUser()->getStage() == 2)
        {
            return $this->redirectToRoute("stageTwo");
        }
        return $this->redirectToRoute("app_home");
    }


    #[Route('/game/choice/{name}', name: 'choice', requirements : ['name' =>  '\w+'])]
    public function choiceHorus(string $name, SkillRepository $skillRepository, SkillTableRepository $skillTableRepository,
    DemonBaseRepository $demonBaseRepository, DemonTraitRepository $demonTraitRepository,
    EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getStage() == 0)
        {
            switch($name)
            {
                case "Horus":
                    $demonBase = $this->pickDemonBase($demonBaseRepository, 'horus');
                    $playerDemonTrait = $this->traitGen($demonTraitRepository);
                    $skills = $skillTableRepository->findBy(["level" => 1, "demonBase" => $demonBase->getId()],["id" => "ASC"]);
                    $skill = $skills[0]; //level on will only have on skill
                    $skill = $skill->getSkill();
                    break;

                case "Xiuhcoatl":
                    $demonBase = $this->pickDemonBase($demonBaseRepository, 'Xiuhcoatl');
                    $playerDemonTrait = $this->traitGen($demonTraitRepository);
                    $skills = $skillTableRepository->findBy(["level" => 1, "demonBase" => $demonBase->getId()],["id" => "ASC"]);
                    $skill = $skills[0]; //level on will only have on skill
                    $skill = $skill->getSkill();
                    break;
                
                case "Chernobog":
                    $demonBase = $this->pickDemonBase($demonBaseRepository, 'Chernobog');
                    $playerDemonTrait = $this->traitGen($demonTraitRepository);
                    $skills = $skillTableRepository->findBy(["level" => 1, "demonBase" => $demonBase->getId()],["id" => "ASC"]);
                    $skill = $skills[0]; //level on will only have on skill
                    $skill = $skill->getSkill();
                    break;
            }

            $demonPlayer = new DemonPlayer; //create a demon
            $demonPlayer->setDemonBase($demonBase); //set base template
            $demonPlayer->setTrait($playerDemonTrait); //generate a trait
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

    public function inBattleCheck(Request $request, PlayerRepository $playerRepository, BattleRepository $battleRepository)
    {
        $session = $request->getSession();
        $firstDemonPlayer = $this->getUser()->getDemonPlayer();
        if ($firstDemonPlayer->isEmpty()) return  $inBattle = false;
        $firstDemonPlayer = $firstDemonPlayer[0]->getId();
        $inBattle = $battleRepository->findBy(["demonPlayer1" => $firstDemonPlayer]);
        if($inBattle === null) return $inBattle = false;
    }

    /**
     * Use this method to refresh token roles immediately ||By PixelShaped https://github.com/symfony/symfony/issues/39763#issuecomment-925903934
     */
    // public function refreshToken($user, TokenStorageInterface $tokenStorage): void
    // {
    //     $token = new UsernamePasswordToken(
    //         $user,
    //         null,
    //         'main', // your firewall name
    //         $user->getRoles()
    //     );
    //     $tokenStorage->setToken($token);
    // }

}
