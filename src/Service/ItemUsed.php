<?php
namespace App\Service;

use App\Repository\ItemRepository;
use App\Repository\BattleRepository;
use App\Repository\HaveItemRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ItemUsed extends AbstractController
{

    private ItemRepository $itemRepository;
    private HaveItemRepository $haveItemRepository;
    private EntityManagerInterface $em;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $em, HaveItemRepository $haveItemRepository, ItemRepository $itemRepository, RequestStack $requestStack)
    {
        $this->itemRepository = $itemRepository;
        $this->em = $em;
        $this->requestStack = $requestStack;
        $this->haveItemRepository = $haveItemRepository;
    }

    public function itemUsed(array $data)  : Response
    {
        $itemId = $data['itemId'];
        $errors = null;

        //pick the selected item, fetch cost, fetch player gold stack, calculate if he can afford 
        $selectedHaveItem = $this->haveItemRepository->findOneBy([
            "id"=>$itemId, 
            "player" => $this->getUser()->getId()
        ]);
        $selectedItem = $selectedHaveItem->getItem();
        //don't remove item if on full hp
        if($data['currentHpPlayer'] == $data['maxHpPlayer'])
        {
            return new JsonResponse(
                [
                    'doNothing' => true,
                    ]
                );
        }
        if ($selectedHaveItem->getQuantity() == 1) //Check if there is one or + in inv
        {
            if ($selectedItem->getCategory()->getId() == 1) //using healing item
            {//Were are IN the healing category and now we parameter the effect of each item 
                switch ($selectedItem->getId()) 
                {
                    case 1://potion
                        $hpHealed = 50;
                        break;
                    case 2://super Potion
                        $hpHealed = 100;
                        break;
                    case 3://Hyper Potion
                        $hpHealed = 150;
                        break;
                }
                $this->em->remove($selectedHaveItem);
                $this->em->flush();                    
                return new JsonResponse(
                    [
                        'status' => 'success',
                        'errors' => $errors,
                        'data' => $data,
                        'hpHealed' => $hpHealed,
                        'curr' => $data['currentHpPlayer'],
                        'max' => $data['maxHpPlayer'],
                        'remains' => null,
                    ]);
            }
            else
            {
                //other item category here not using healing
            }
        }
        else // qt remains
        {
            $selectedHaveItem->setQuantity(($selectedHaveItem->getQuantity())- 1);
            $this->em->flush();
            $remainingItem = $selectedHaveItem->getQuantity();
            if ($selectedItem->getCategory()->getId() == 1)
            {
                switch ($selectedItem->getId())
                {
                    case 1://potion
                        $hpHealed = 50;
                        break;
                    case 2://super Potion
                        $hpHealed = 100;
                        break;
                    case 3://Hyper Potion
                        $hpHealed = 150;
                        break;
                }
                return new JsonResponse(
                    [
                        'status' => 'success',
                        'errors' => $errors,
                        'data' => $data,
                        'hpHealed' => $hpHealed,
                        'remains' => $remainingItem,
                        'curr' => $data['currentHpPlayer'],
                        'max' => $data['maxHpPlayer']
                    ]
                    );
            }
        }
        return 0;
    }
}