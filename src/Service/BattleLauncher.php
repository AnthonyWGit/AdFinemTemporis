<?php
namespace App\Service;

use App\Service\Math;
use App\Entity\Battle;
use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BattleLauncher extends AbstractController
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;
    private DemonGenerator $demonGenerator;
    private BattleChecker $battleChecker;
    private BattleRepository $battleRepository;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager,
    DemonGenerator $demonGenerator, BattleChecker $battleChecker, BattleRepository $battleRepository)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->demonGenerator = $demonGenerator;
        $this->battleChecker = $battleChecker;
        $this->battleRepository = $battleRepository;
    }

    public function finalCombat(): Response
    {
        if ($this->getUser()->getStage() !== 5) return $this->redirectToRoute('app_home');
        $session = $this->requestStack->getCurrentRequest()->getSession();
        if (/* $session->get('placeholder') == 'a' && */ !$this->battleChecker->inBattleCheck())
        {
            $session->remove('placeholder');
            $battle = new Battle;
            $battle->setXpEarned(750);
            $battle->setGoldEarned(80);
            $playerDemons = $this->getUser()->getDemonPlayer();
            $generatedCpu = $this->demonGenerator->cpuDemonGen("Nyarlathotep", 1500);
            $playerDemon = $playerDemons[0];
            $playerDemon->addFighter($battle);
            $generatedCpu->addFighter2($battle);
            $this->entityManager->persist($battle);
            $this->entityManager->persist($this->getUser());
            $this->entityManager->flush();
            $xpDemon = $playerDemon->getExperience();
            $percentage = Math::calculateLevelPercentage($xpDemon);
            
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
                $number = rand(0,1);
                if ($number == 0)
                {
                    $initiative = $this->getUser()->getUsername();
                }
                else
                {
                    $initiative = "CPU";
                }
            }
            $session->set('playerDemonLevel', $playerDemon->getLevel());
            return $this->render('game/combatTwo.html.twig', [
                'cpuDemon' => $generatedCpu,
                'playerDemons' => $playerDemons,
                'intiative' => $initiative,
                'percentage' => $percentage
            ]);    
        }
        else if (/*$this->isGranted('ROLE_IN_COMBAT')*/ $this->battleChecker->inBattleCheck()) //combat is still in progress so the user is put in it 
        {
            $playerDemons = $this->getUser()->getDemonPlayer();
            $playerDemon = $playerDemons[0];
            $battleContent = $this->battleRepository->findOneBy(["demonPlayer1" => $playerDemon]);
            $generatedCpu = $battleContent->getDemonPlayer2();
            //current xp values for xp bar 
            $xpDemon = $playerDemon->getExperience();
            $percentage = Math::calculateLevelPercentage($xpDemon);
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
                $number = rand(0,1);
                if ($number == 0)
                {
                    $initiative = $this->getUser()->getUsername();
                }
                else
                {
                    $initiative = "CPU";
                }
            }
            return $this->render('game/combatTwo.html.twig', [
                'cpuDemon' => $generatedCpu,
                'playerDemons' => $playerDemons,
                'initiative' => $initiative,
                'percentage' => $percentage,
            ]);    
        }
        else if ($this->getUser()->getStage() == 2)
        {
            return $this->redirectToRoute("stageTwo");
        }
        else if ($this->getUser()->getStage() == 3)
        {
            return $this->redirectToRoute("stageThree");
        }
        return $this->redirectToRoute("app_home");
    }
}