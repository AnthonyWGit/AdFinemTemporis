<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemFormType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/item/show/{name}', name: 'itemDetail')]
    public function detail(Item $item): Response
    {
        return $this->render('item/detail.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('admin/item/new', name: 'newItem')]
    #[Route('admin/item/{name}/edit', name: 'editItem')]
    public function new(Item $item = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($item === null) {
            $item = new Item();
        }
        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $item = $form->getData();
                $entityManager->persist($item); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('itemsList'); //redirect to list items if everything is ok
            }
        
        return $this->render("item/new.html.twig", ['formNewItem' => $form, 'edit' => $item->getId()]);
    }

    #[Route('admin/item/{name}/delete', name: 'deleteItem')]
    public function itemDelete(Item $item, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($item);
        $entityManager->flush();
        $this->addFlash(
            'noticeChange',
            'This entry has been deleted'
        );
        return $this->redirectToRoute('itemsList');
    }

}
