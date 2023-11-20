<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\HaveItem;
use App\Entity\DemonPlayer;
use App\Form\HaveItemFormType;
use App\Form\DemonPlayerFormType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemonPlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'usersList')]
    public function index(PlayerRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ["id" => "ASC"]);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/{id}/banAction', name: 'banAction')]
    public function banAction(Player $player, PlayerRepository $userRepository, EntityManagerInterface $em): Response
    {
        if ($player->getId() == $this->getUser()->getId()) //Can use current logged id because it is in secure path 
        {
            $this->addFlash(
                'notice',
                'You can\'t do that !'
            );
        }
        $player->addRole("ROLE_BANNED");
        $em->flush();
        return $this->redirectToRoute('usersList');
    }

    #[Route('/admin/{id}/unbanAction', name: 'unbanAction')]
    public function unbanAction(Player $player, PlayerRepository $userRepository, EntityManagerInterface $em): Response
    {
        $player->removeRole("ROLE_BANNED");
        $em->flush();
        return $this->redirectToRoute('usersList');
    }

    #[Route('/admin/show/{id}', name: 'userDetail')]
    public function detail(Player $player): Response
    {
        return $this->render('user/detail.html.twig', [
            'player' => $player,
            'demons' => $player->getDemonPlayer(),
        ]);
    }
    
    #[Route('/admin/demon/{player}/new', name: 'playerNewDemon')]
    public function new(Player $player,  Request $request, EntityManagerInterface $entityManager): Response
    {
        $demonPlayer = new DemonPlayer();
        $form = $this->createForm(DemonPlayerFormType::class, $demonPlayer, ['player' => $player]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $demonPlayer = $form->getData();
                $entityManager->persist($demonPlayer); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('userDetail', ['id' => $player->getId()]);
            }
        
        return $this->render("user/new.html.twig", ['formNewDemonPlayer' => $form, 'edit' => $demonPlayer->getId()]);
    }

    #[Route('/admin/demon/{dp}/{player}/edit', name: 'playerEditDemon')]
    public function edit(DemonPlayer $dp, Player $player , Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(DemonPlayerFormType::class, $dp, ['player' => $player]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $demonPlayer = $form->getData();
                $entityManager->persist($dp); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('userDetail', ['id' => $player->getId()]);
            }
        
        return $this->render("user/new.html.twig", ['formNewDemonPlayer' => $form, 'edit' => $dp->getId()]);
    }

    #[Route('admin/demon/{id}/delete/{demonPlayer}', name: 'deletePlayerDemon')]
    public function demonPlayerDelete(Player $player,DemonPlayer $demonPlayer, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($demonPlayer);
        $entityManager->flush();
        $this->addFlash(
            'noticeChange',
            'This entry has been deleted'
        );
        return $this->redirectToRoute('userDetail', ['id' => $player->getId()]);
    }

    #[Route('/admin/{id}/updateDemons', name: 'updateDemons')]
    public function updateDemonsAction(Player $player, Request $request, EntityManagerInterface $em) : Response
    {
        $error = false;
        $submittedToken = $request->request->get('csrf_token');
        if ($this->isCsrfTokenValid('delete-item', $submittedToken))
        {
            // Check if the request method is POST
            if ($request->isMethod('POST')) 
            {
                // Retrieve all POST parameters
                $postData = $request->request->all();

                // Iterate over each demon
                foreach ($postData as $key => $value) 
                {
                    if (strpos($key, '-') === false) 
                    {
                        if($key == 'csrf_token') 
                        {
                            // Flush the changes to the database
                            $em->flush();   
                            //token is last field so it means we've gone through the form and we can flush redirect
                            return $this->redirectToRoute('userDetail', ['id' => $player->getId()]);
                        }
                    }
                    // Split the key on '-' to get the attribute and demon id
                    list($attribute, $demonId) = explode('-', $key);
                    // Find the demon by id
                    $demon = $em->getRepository(DemonPlayer::class)->find($demonId);
        
                    // Update the attribute for the demon
                    switch ($attribute) 
                    {
                        case 'str':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setStrPoints($value);
                            break;
                        case 'end':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setEndPoints($value);
                            break;
                        case 'agi':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setAgiPoints($value);
                            break;
                        case 'int':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setIntPoints($value);
                            break;
                        case 'lck':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setLckPoints($value);               
                            break;
                        case 'pts':
                            if ( !is_numeric($value) || $value < 0 ) $error = true; else $demon->setLvlUpPoints($value);
                            break;
                    }
        
                    // Persist the updated demon
                    if (!$error)
                    {
                        $em->persist($demon);
                    }
                    else
                    {
                        $this->addFlash(
                            'noticeChange',
                            'You can\'t put a negative value'
                        );
                        return $this->redirectToRoute('userDetail' , ['id' => $player->getId()]);
                    }
                }

            }
        }
        else
        {
            return $this->redirectToRoute('app_home');
        }
    }


    #[Route('/admin/show/{id}/haveItem', name: 'userDetailItem')]
    public function detailItem(Player $player): Response
    {
        return $this->render('user/detailItem.html.twig', [
            'player' => $player,
            'items' => $player->getHaveItem(),
        ]);
    }
    
    #[Route('/admin/haveItems/{player}/new', name: 'playerNewHaveItem')]
    #[Route('/admin/haveItems/{player}/{haveItem}/edit', name: 'playerEditHaveItem')]
    public function newHItem(Player $player, HaveItem $haveItem = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($haveItem === null) {
            $haveItem = new HaveItem();
        }
        $form = $this->createForm(HaveItemFormType::class, $haveItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $demonPlayer = $form->getData();
                $entityManager->persist($haveItem); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'noticeChange',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('userDetailItem', ['id' => $player->getId()]);
            }
        
        return $this->render("user/newItem.html.twig", ['formNewHaveItem' => $form, 'edit' => $haveItem->getId()]);
    }
}
