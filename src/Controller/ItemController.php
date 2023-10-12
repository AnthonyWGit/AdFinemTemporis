<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'itemsList')]
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy([], ["id" => "ASC"]);
        return $this->render('item/index.html.twig', [
            'items' => $items,
        ]);
    }

}
