<?php

namespace App\Controller;

use App\Service\Math;
use App\Entity\Battle;
use App\Entity\HaveItem;
use App\Entity\DemonPlayer;
use App\Service\BattleChecker;
use App\Service\DemonGenerator;
use App\Service\TraitGenerator;
use Doctrine\ORM\Mapping\Entity;
use App\Service\CombatResolution;
use App\Repository\ItemRepository;
use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use App\Repository\HaveItemRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemonPlayerRepository;
use App\Service\BattleLauncher;
use App\Service\ItemUsed;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Game2Controller extends AbstractController
{
    #[Route('/game/merchant', name: 'ajaxMerchant')]
    public function transaction(Request $request, ItemRepository $itemRepository, EntityManagerInterface $em)  : Response
    {
        $line = null;
        $post = null;
        if(!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException("Page not found");
        }
        $data = $request->request->all();
        $number = $data['number'];
        $itemId = $data['itemId'];
        $errors = null;
        if (isset($number))
        {
            $number = intval($number);
            $post = filter_var($number,FILTER_SANITIZE_NUMBER_INT);
            if (!filter_var($post,FILTER_VALIDATE_INT)) 
            {
                $errors = "Some incorrect data was sent";
                return new JsonResponse(['status' => 'success', 'errors' => $errors,'data' => $data]);
            }
        }
        else{
            $errors = "empty data";
            return new JsonResponse(['status' => 'success', 'errors' => $errors,'data' => $data]);
        }
        //pick the selected item, fetch cost, fetch player gold stack, calculate if he can afford 
        $selectedItem = $itemRepository->findOneBy(["id"=>$itemId]);
        $cost = $selectedItem->getCost() * $number;
        $currentGoldPlayer = $this->getUser()->getGold();
        if ($cost > $currentGoldPlayer)
        {
            $errors = "You don't have enough money";
            return new JsonResponse(['status' => 'success', 'errors' => $errors,'data' => $data]);
        }
        else
        {
            $status = 1;
            $afterPay = $currentGoldPlayer - $cost;
            $this->getUser()->setGold($afterPay);
            //Go through every Item-quantity pair
            foreach ($this->getUser()->getHaveItem() as $itemSet)
            {
                $status = null;
                //take item name from pair ; if name is same as item bough then just add quantity to the pair
                $itemName = $itemSet->getItem()->getName();
                if ($selectedItem->getName() == $itemName)
                {
                    $line = $em->getRepository(HaveItem::class)->findOneBy(
                        [
                        "player" => $this->getUser()->getId(),
                        "item" => $itemSet->getItem()->getId()
                    ],
                    );
                    $initialQt = $line->getQuantity();
                    $line->setQuantity($initialQt + $number);
                    $em->flush();
                    $status = 0;
                }
            }

            if ($status == 0 && $line !== null) //When buying existing item
            {
                $qt = $line->setQuantity($initialQt + $number);
                $qt = $line->getQuantity();
                $ifNewItem = null;
                $target = $line->getItem()->getId();
                $gold = $this->getUser()->getGold();
            }
            else
            {
                $newPair = new HaveItem();
                $newPair->setItem($selectedItem);
                $newPair->setPlayer($this->getUser());
                $newPair->setQuantity($number);
                $em->persist($newPair);
                $em->flush();
                $this->getUser()->addHaveItem($newPair);

                $qt = $number;
                $ifNewItem = $newPair->getItem()->getName();
                $target = $newPair->getItem()->getId();
                $gold = $this->getUser()->getGold();
            }
            return new JsonResponse(
                [
                    'status' => 'success',
                    'errors' => $errors,
                    'data' => $data,
                    'quantity' => $qt,
                    'newItem' => $ifNewItem,
                    'target' => $target,
                    'gold' => $gold
                    ]
                );
        }
        return new JsonResponse(['status' => 'success', 'errors' => $errors,'data' => $data]);
    }

    #[Route('/game/ajaxe/itemUsed', name: 'itemUsed')]
    public function itemUsed(Request $request, ItemUsed $itemUsed)
    {
        if(!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException("Page not found");
        }
        $data = $request->request->all();
        return $itemUsed->itemUsed($data);
    }

    #[Route('/game/stageThree', name: 'stageThree')]
    public function stageThree(BattleChecker $checker, EntityManagerInterface $em)
    {
        $starter = $this->getUser()->getDemonPlayer();
        if ($checker->inBattleCheck()) return $this->redirectToRoute('combat');
        if ($this->getUser()->getStage() !== 3 && $this->getUser()->getStage() !== 9999)
        {
            return $this->redirectToRoute("cheating");
        }
        $this->getUser()->setStage(3);
        $em->flush();
        return $this->render('game/stageThree.html.twig', [
            'demon' => $starter[0],
            'demons' => $starter,
        ]);
    }

    #[Route('/game/combat/resolveBis', name: 'combatResolveBis')]
    public function combatResolve(CombatResolution $combatResolution, BattleChecker $checker): Response
    {
        //If user is not stage 3 or 10000 then he'll be redirected 
        if (($this->getUser()->getStage() !== 3 && $this->getUser()->getStage() !== 10000) && !$checker->inBattleCheck())return $this->redirectToRoute("cheating");
        if ($this->getUser()->getStage() == 3 )
        {
            $combatResolution->combatResolve(4);
            return $this->redirectToRoute('stageFour');                     
        }
        if ($this->getUser()->getStage() == 10000 )
        {
            $combatResolution->combatResolve(10000);
            return $this->redirectToRoute('secondHub');                     
        }
        if ($this->getUser()->getStage() == 5 )
        {
            $combatResolution->combatResolve(6);
            return $this->redirectToRoute('stageSix');                     
        }
        return $this->redirectToRoute('app_home');
    }

    #[Route('/game/stageFour', name: 'stageFour')]
    public function stageFour(BattleChecker $checker): Response
    {   if ($checker->inBattleCheck()) return $this->redirectToRoute("combat");
        if ($this->getUser()->getStage() != 4) return $this->redirectToRoute("cheating");
        $this->getUser()->setStage(10000);
        $demons=$this->getUser()->getDemonPlayer();
        return $this->render('game/stageFourr.html.twig', [
            'demon' => $demons[0],
            'demons' => $demons
        ]);
    }

    #[Route('/game/stageFive', name: 'stageFive')]
    public function stageFive(BattleChecker $checker, EntityManagerInterface $em): Response
    {   if ($checker->inBattleCheck()) return $this->redirectToRoute("combat");
        if ($this->getUser()->getStage() !== 10000 && $this->getUser()->getStage() !== 5) return $this->redirectToRoute("cheating");
        $this->getUser()->setStage(5);
        $em->flush();
        $demons=$this->getUser()->getDemonPlayer();
        return $this->render('game/stageFive.html.twig', [
            'demon' => $demons[0],
            'demons' => $demons
        ]);
    }

    #[Route('/game/stageSix', name: 'stageSix')]
    public function stageSix(BattleChecker $checker, EntityManagerInterface $em): Response
    {   if ($checker->inBattleCheck()) return $this->redirectToRoute("combat");
        if ($this->getUser()->getStage() !== 6) return $this->redirectToRoute("cheating");
        $this->getUser()->setStage(6);
        $demons=$this->getUser()->getDemonPlayer();
        return $this->render('game/stageSix.html.twig', [
            'demon' => $demons[0],
            'demons' => $demons
        ]);
    }

    #[Route('/game/hub/second', name: 'secondHub')]
    public function secondHub(BattleChecker $checker, ItemRepository $itemRepository, HaveItemRepository $haveItemRepository): Response
    {
        if (($this->getUser()->getStage() !== 3 && $this->getUser()->getStage() !== 10000)) return $this->redirectToRoute("cheating");
        if ($checker->inBattleCheck()) return $this->redirectToRoute("combat");
        $demons = $this->getUser()->getDemonPlayer();
        $items = $itemRepository->findBy([], ["id" => "ASC"]);
        $itemsPlayer = $haveItemRepository->findBy(["player" => $this->getUser()->getId()], ["id"=>"ASC"]);
        return $this->render('game/hub2.html.twig', [
            'demons' => $demons,
            'items' => $items,
            'itemsPlayer' => $itemsPlayer
        ]);
    }

   #[Route('/game/secondCombat', name: 'combat2')]
    public function combat(Request $request, ?Battle $battle, 
    HaveItemRepository $haveItemRepository,
    ?BattleRepository $battleRepository, EntityManagerInterface $entityManager, BattleChecker $checker ,
    DemonGenerator $demonGenerator): Response
    {
        if (!in_array($this->getUser()->getStage(),[3,5,10000])) return $this->redirectToRoute('cheating');
        $session = $request->getSession();
        if (!$checker->inBattleCheck())
        {
            $session->remove('placeholder');
            $battle = new Battle;
            $battle->setXpEarned(750);
            $battle->setGoldEarned(80);
            $playerDemons = $this->getUser()->getDemonPlayer();
            $generatedCpu = $demonGenerator->cpuDemonGen("Ymir", 750);
            $playerDemon = $playerDemons[0];
            $playerDemon->addFighter($battle);
            $generatedCpu->addFighter2($battle);
            $entityManager->persist($battle);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
            $xpDemon = $playerDemon->getExperience();
            $percentage = Math::calculateLevelPercentage($xpDemon);
            $itemsPlayer = $haveItemRepository->findBy(["player" => $this->getUser()->getId()], ["id"=>"ASC"]); //get items
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
                'percentage' => $percentage,
                'itemsPlayer' => $itemsPlayer
            ]);    
        }
        else if ($checker->inBattleCheck()) //combat is still in progress so the user is put in it 
        {
            $playerDemons = $this->getUser()->getDemonPlayer();
            $playerDemon = $playerDemons[0];
            $battleContent = $battleRepository->findOneBy(["demonPlayer1" => $playerDemon]);
            $generatedCpu = $battleContent->getDemonPlayer2();
            //current xp values for xp bar 
            $xpDemon = $playerDemon->getExperience();
            $percentage = Math::calculateLevelPercentage($xpDemon);
            $itemsPlayer = $haveItemRepository->findBy(["player" => $this->getUser()->getId()], ["id"=>"ASC"]); //get items
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
                'itemsPlayer' => $itemsPlayer
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

    #[Route('/game/finalBattle', name: 'finalBattle')]
    public function finalCombat(BattleLauncher $battleLauncher) : Response
    {
        return $battleLauncher->finalCombat();
    }

    #[Route('/game/credits', name: 'credits')]
    public function credits(BattleChecker $battleChecker) : Response
    {
        if ($battleChecker->inBattleCheck() && $this->getUser()->getStage() != 6) $this->redirectToRoute('cheating');
        return $this->render('game/credits.html.twig');
    }
}
