<?php

namespace App\Controller;

use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BattleChecker;

class Game2Controller extends AbstractController
{
    #[Route('/game/stageThree', name: 'stageThree')]
    public function stageThree(BattleChecker $checker, EntityManagerInterface $em)
    {
        $starter = $this->getUser()->getDemonPlayer();
        if ($checker->inBattleCheck()) return $this->redirectToRoute('combat');
        if ($this->getUser()->getStage() != (9999||3)) 
        {
            return $this->redirectToRoute("app_home");
        }
        $this->getUser()->setStage(3);
        $em->flush();
        return $this->render('game/stageThree.html.twig', [
            'demon' => $starter[0],
            'demons' => $starter,
        ]);
    }
}
