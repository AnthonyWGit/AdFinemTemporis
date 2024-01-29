<?php

namespace App\Service;

use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemonPlayerRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CombatResolution extends AbstractController
{

    private RequestStack $requestStack;
    private BattleRepository $battleRepository;
    private EntityManagerInterface $entityManager;
    private SkillTableRepository $skillTableRepository;
    private DemonPlayerRepository $demonPlayerRepository;
    public function __construct(RequestStack $requestStack, 
     BattleRepository $battleRepository, SkillTableRepository $skillTableRepository,
     EntityManagerInterface $entityManager,
    DemonPlayerRepository $demonPlayerRepository)
    {
        $this->requestStack = $requestStack;
        $this->battleRepository = $battleRepository;
        $this->entityManager = $entityManager;
        $this->skillTableRepository = $skillTableRepository;
        $this->demonPlayerRepository = $demonPlayerRepository;
    }

    public function combatResolve(int $stage)
    {
        $request = $this->requestStack->getCurrentRequest();
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
                $battle = $this->battleRepository->findOneBy(["demonPlayer1" => $playerDemon]);
                $generatedCpu = $battle->getDemonPlayer2();
                //______________________XP & GOLD calc________________________________
                $currentGold = $this->getUser()->getGold();
                $currentXp = $playerDemon->getExperience();
                $goldEarned = $battle->getGoldEarned();
                $xpEarned =  $battle->getXpEarned();
                $totalXp = $xpEarned + $currentXp;
                $totalGold = $goldEarned + $currentGold;
                //___________________________________________________________________
                $this->getUser()->setGold($totalGold);
                $playerDemon->setExperience($totalXp);
                // Add XP and store each demon's level after the XP addition
                $levelsAfter = [];
                foreach ($playerDemons as $demonAfter) {
                    // Add XP to $demonAfter here...

                    $levelsAfter[$demonAfter->getId()] = $demonAfter->getLevel();
                }
                $this->entityManager->remove($battle);
                $this->entityManager->remove($generatedCpu);
                $this->entityManager->flush();
                if (($this->getUser()->getStage() > 2 && $session->get("isCombatResolved") == "Yes"))
                {
                    $this->getUser()->setStage($stage);
                    $this->entityManager->flush();
                }
                $session->remove('Winner');
                $session->remove("isCombatResolved");

                foreach ($playerDemons as $demon)
                {
                    $demonLevel = $demon->getLevel();
                    $learnableSkill =  $this->skillTableRepository->findOneBy(["level" => $demonLevel, "demonBase" => $demon->getDemonBase()->getId()]);
                    if ($learnableSkill !== null)
                    {
                        $skill = $learnableSkill->getSkill(); 
                        $demon->addSkill($skill);
                        $this->addFlash(
                            'notice',
                            'One of your Demon gained a new skill !'
                        );
                        $this->entityManager->persist($demon);
                        $this->entityManager->flush();
                    }
                }
                // Compare each demon's level before and after the XP addition
                foreach ($levelsBefore as $id => $levelBefore) {
                    if ($levelBefore != $levelsAfter[$id]) {
                        $this->demonPlayerRepository->findOneBy(["id" => strval($id)])->addLvlUpPoints($levelsAfter[$id] - $levelBefore); //points gained are difference level after - level be4
                        $this->entityManager->flush();
                        $this->addFlash(
                            'noticeLevel',
                            $this->demonPlayerRepository->findOneBy(["id" => strval($id)])->getDemonBase()->getName() .' gained a level !');
                        $this->addFlash(
                            'noticeLevel',
                            $this->demonPlayerRepository->findOneBy(["id" => strval($id)])->getDemonBase()->getName(). ' gained a lvlUp point !'
                        );
                    }
                }
            }  
            else $this->redirectToRoute('app_home');
        }
    }
}