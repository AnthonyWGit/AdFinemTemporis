<?php

namespace App\Controller;

use App\Service\Simulation;
use App\Entity\Skill;
use App\Entity\DemonPlayer;
use App\Form\TheLabSelfDemonType;
use App\Repository\SkillRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TheLabController extends AbstractController
{    
    #[Route('/the_lab', name: 'the_lab')]
    public function index(SkillRepository $skillRepository, DemonTraitRepository $traitRepository, 
    DemonBaseRepository $demonBaseRepository, SkillTableRepository $skillTableRepository, Request $request): Response
    {
        $allDemons = $demonBaseRepository->findBy([],["name" => "ASC"]);
        $firstDemonInList = $allDemons[0];

        $form = $this->createForm(TheLabSelfDemonType::class, null, ['firstD' => $firstDemonInList]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $data = $form->getData();
                // $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                // (
                //     'noticeChange',
                //     'Computing...'
                // );
                // $request->getSession()->set('data', $data);
                $response = $this->forward('App\Controller\TheLabController::calculator', [
                    'data' => $data,
                ]);
                return $response;
                // return $this->redirectToRoute('the_labCalc'); //redirect to list stagiaires if everything is ok
            }

        return $this->render('the_lab/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/the_lab/calc', name: 'the_labCalc')]
    public function calculator(Request $request, Array $data, EntityManagerInterface $em, DemonBaseRepository $demonBaseRepository, SkillRepository $skillRepository): Response
    {

        $demonsArray = Simulation::simulate($request, $data, $em, $demonBaseRepository, $skillRepository);

        // dd($skillObject, $skillDmgSimulatedPure, $demonBaseObject->getStrDemonBase(), $calculated["the_lab_self_demon"]["str"], $strLevelUpPoints, $demonBaseObject, $demonPlayerSimulated);
        return $this->render('the_lab/calculations.html.twig',[
            'demonPlayer' => $demonsArray['demonPlayer'],
            'maxHpSimulated' => $demonsArray['maxHp'],
            'skillDmgSimulatedPure' => $demonsArray['dmgPlayer'],
            'demonCPU' => $demonsArray["demonCPU"],
            'maxHpSimulatedCPU' => $demonsArray['maxHpCPU'],
            'levelCPU' => $demonsArray['levelCPU'],
            'level' => $demonsArray['level'],
            'trueDmg' => $demonsArray["trueDmg"],
        ]);            
    }

    #[Route('/the_lab/ajax', name: 'labAjax')]
    public function ajax(Request $request, DemonBaseRepository $demonBaseRepository)
    {
        $incomingData = $request->request->all();
        $demon = $demonBaseRepository->findOneBy(['id' => $incomingData['demonId']]);

        $newPlaceholderStr = $demon->getStrDemonBase();
        $newPlaceholderEnd = $demon->getEndDemonBase();
        $newPlaceholderAgi = $demon->getAgiDemonBase();
        $newPlaceholderInt = $demon->getIntDemonBase();
        $newPlaceholderLck = $demon->getLckDemonBase();

        $outcomingData = [
            $newPlaceholderStr, $newPlaceholderEnd, $newPlaceholderAgi, $newPlaceholderInt, $newPlaceholderLck,
        ]; 
        return new JsonResponse($outcomingData);
    }

    #[Route('/the_lab/ajaxCPU', name: 'labAjaxCPU')]
    public function ajaxCPU(Request $request, DemonBaseRepository $demonBaseRepository)
    {
        $incomingData = $request->request->all();
        $demonCPU = $demonBaseRepository->findOneBy(['id' => $incomingData['demonIdCPU']]);

        $newPlaceholderStrCPU = $demonCPU->getStrDemonBase();
        $newPlaceholderEndCPU = $demonCPU->getEndDemonBase();
        $newPlaceholderAgiCPU = $demonCPU->getAgiDemonBase();
        $newPlaceholderIntCPU = $demonCPU->getIntDemonBase();
        $newPlaceholderLckCPU = $demonCPU->getLckDemonBase();

        $outcomingData2 = [
            $newPlaceholderStrCPU, $newPlaceholderEndCPU, $newPlaceholderAgiCPU, $newPlaceholderIntCPU, $newPlaceholderLckCPU,
        ]; 
        return new JsonResponse($outcomingData2);
    }
}
