<?php
namespace App\Service;

use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BattleChecker extends AbstractController
{

    private PlayerRepository $playerRepository;
    private BattleRepository $battleRepository;
    private RequestStack $requestStack;

    public function __construct(PlayerRepository $playerRepository, BattleRepository $battleRepository, RequestStack $requestStack)
    {
        $this->playerRepository = $playerRepository;
        $this->battleRepository = $battleRepository;
        $this->requestStack = $requestStack;
    }

    public function inBattleCheck()
    {
        $request = $this->requestStack->getCurrentRequest();
        // $session = $request->getSession();
        $firstDemonPlayer = $this->getUser()->getDemonPlayer();
        if ($firstDemonPlayer->isEmpty()) 
        {
            return  $inBattle = false;
        }
        else
        {
            $firstDemonPlayer = $firstDemonPlayer[0]->getId();
            $inBattle = $this->battleRepository->findBy(["demonPlayer1" => $firstDemonPlayer]);
            if ($inBattle == null) return $inBattle = false; else return $inBattle = true; 
        }
    }
}