<?php

namespace App\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TheLabController extends AbstractController
{
    // #[Route('/the_lab', name: 'the_lab')]
    // public function index(SkillRepository $skillRepository, DemonTraitRepository $traitRepository, 
    // DemonBaseRepository $demonBaseRepository, SkillTableRepository $skillTableRepository): Response
    // {
    //     $skills = $skillRepository->findBy([], ["name" => "ASC"]);
    //     $traits = $traitRepository->findBy([], ["name" => "ASC"]);
    //     $demonsBase = $demonBaseRepository->findBy([], ["name" => "ASC"]);
    //     $skillsTable = $skillTableRepository->findBy([], ["id" => "ASC"]);
    //     return $this->render('the_lab/index.html.twig', [
    //         'controller_name' => 'TheLabController',
    //         'skills' => $skills,
    //         'traits' => $traits,
    //         'demonsBase' => $demonsBase,
    //         'skillsTable' => $skillsTable,
    //     ]);
    // }
    
    #[Route('/the_lab', name: 'the_lab')]
    public function index(SkillRepository $skillRepository, DemonTraitRepository $traitRepository, 
    DemonBaseRepository $demonBaseRepository, SkillTableRepository $skillTableRepository, Request $request): Response
    {
        $form = $this->createForm(TheLabSelfDemonType::class,
        [
            'action' => ($this->generateUrl('the_labCalc')),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $data = $form->getData();
                // $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                // (
                //     'noticeChange',
                //     'Computing...'
                // );
                
                return $this->redirectToRoute('the_labCalc'); //redirect to list stagiaires if everything is ok
            }

        return $this->render('the_lab/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/the_lab/calc', name: 'the_labCalc')]
    public function calculator(Request $request, EntityManagerInterface $em, DemonBaseRepository $demonBaseRepository, SkillRepository $skillRepository): Response
    {
        $calculated = $request->request->all();

        $demonPlayerSimulated = new DemonPlayer();

        $skillSimulated = new Skill();
        $levelSimulated = $calculated["the_lab_self_demon"]['level']; 
        $demonBaseObject = $demonBaseRepository->findOneBy(['id' => $calculated["the_lab_self_demon"]["demonBase"]]);
        $skillObject = $skillRepository->findOneBy(['id' => $calculated["the_lab_self_demon"]["skill"]]);
        // $skillDmg = $skillObject->
        $totalEnd = $calculated["the_lab_self_demon"]["end"];

        $maxHpSimulated = $demonPlayerSimulated->getMaxHpFictif($levelSimulated, $totalEnd, $demonBaseObject);

        //Calculating points from the simulated demon
        $strLevelUpPoints = $calculated["the_lab_self_demon"]["str"] - $demonBaseObject->getStrDemonBase();
        $endLevelUpPoints = $calculated["the_lab_self_demon"]["end"] - $demonBaseObject->getEndDemonBase();
        $agiLevelUpPoints = $calculated["the_lab_self_demon"]["int"] - $demonBaseObject->getIntDemonBase();
        $intLevelUpPoints = $calculated["the_lab_self_demon"]["agi"] - $demonBaseObject->getAgiDemonBase();
        $lckLevelUpPoints = $calculated["the_lab_self_demon"]["lck"] - $demonBaseObject->getLckDemonBase();

        $demonPlayerSimulated->setDemonBase($demonBaseObject);
        $demonPlayerSimulated->setStrPoints($strLevelUpPoints);
        $demonPlayerSimulated->setEndPoints($endLevelUpPoints);
        $demonPlayerSimulated->setAgiPoints($agiLevelUpPoints);
        $demonPlayerSimulated->setIntPoints($intLevelUpPoints);
        $demonPlayerSimulated->setLckPoints($lckLevelUpPoints);

        $skillDmgSimulatedPure = $skillObject->dmgCalcSimulatedPure($demonPlayerSimulated);

        // dd($skillObject, $skillDmgSimulatedPure, $demonBaseObject->getStrDemonBase(), $calculated["the_lab_self_demon"]["str"], $strLevelUpPoints, $demonBaseObject, $demonPlayerSimulated);
        return $this->render('the_lab/calculations.html.twig',[
            'calculations' => $calculated,
            'maxHpSimulated' => $maxHpSimulated,
            'skillDmgSimulatedPure' => $skillDmgSimulatedPure,
        ]);            
    }
}
