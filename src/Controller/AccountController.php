<?php

namespace App\Controller;

use App\Form\EmailChangeFormType;
use App\Form\PasswordChangeFormType;
use App\Repository\BattleRepository;
use App\Repository\DemonBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/emailChange', name: 'accountEmailChange')]
    public function changeEmail(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EmailChangeFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //put the email
            $user->setEmail($form->get('email')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('account/emailChange.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/account/passwordChange', name: 'accountPasswordChange')]
    public function changePwd(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordChangeFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //put the email
            $user->setEmail($form->get('password')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('account/passwordChange.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/account/resetProgression', name: 'resetProgression')]
    public function reset(Request $request, BattleRepository $battleRepository, DemonBaseRepository $demonBaseRepository, EntityManagerInterface $entityManager): Response
    {
        $demonsPlayer = $this->getUser()->getDemonPlayer();
        if ($this->getUser()->getStage() == 0) 
        {
            $this->addFlash(
                'notice',
                "You are already starting from the beginning."
            );
            return $this->redirectToRoute("account");
        }
        foreach ($demonsPlayer as $demon)
        {
            if (empty($demon->getFighter()))
            {
                $this->addFlash(
                    'notice',
                    "You can't alter your progress while you're still in combat."
                );
                return $this->redirectToRoute('account');
            }
            else
            {
                $entityManager->remove($demon);
            }
        }
        $itemsPlayers = $this->getUser()->getHaveItem();
        foreach ($itemsPlayers as $item)
        {
            $entityManager->remove($item);
        }
        $this->getUser()->setGold(0);
        $this->getUser()->setStage(0);
        $this->addFlash(
            'notice',
            "You are starting from 0 again."
        );
        $entityManager->flush();
        return $this->redirectToRoute("account");
    }

}
