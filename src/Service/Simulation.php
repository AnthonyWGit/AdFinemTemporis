<?php
namespace App\Service;

use App\Entity\Skill;
use App\Entity\DemonPlayer;
use App\Repository\SkillRepository;
use App\Repository\DemonBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Simulation
{
    public static function simulate(Request $request, Array $data, EntityManagerInterface $em, DemonBaseRepository $demonBaseRepository, SkillRepository $skillRepository): Array
    {
        //for player
        //renaming the data array
        $calculated = $data;
        $calculated = ['the_lab_self_demon' => $calculated];

        //creating a new demonPlayer that won't be put in db 
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

        $dmgPlayer = $skillObject->dmgCalcSimulated($demonPlayerSimulated, $demonCPUSimulated = null, true);

        // for ennemy
        if ($calculated["the_lab_self_demon"]["demonBaseCPU"] && $calculated["the_lab_self_demon"]["traitCPU"] && $calculated["the_lab_self_demon"]["levelCPU"] && 
        $calculated["the_lab_self_demon"]["strCPU"] && $calculated["the_lab_self_demon"]["endCPU"]  && $calculated["the_lab_self_demon"]["intCPU"] 
        && $calculated["the_lab_self_demon"]["agiCPU"]  && $calculated["the_lab_self_demon"]["lckCPU"] )
        {
            $demonCPUSimulated = new DemonPlayer();
            $levelCPUSimulated = $calculated["the_lab_self_demon"]['level']; 
            $demonCPUBaseObject = $demonBaseRepository->findOneBy(['id' => $calculated["the_lab_self_demon"]["demonBaseCPU"]]);
            // $skillDmg = $skillObject->
            $totalEndCPU = $calculated["the_lab_self_demon"]["endCPU"];

            $maxHpSimulatedCPU = $demonCPUSimulated->getMaxHpFictif($levelCPUSimulated, $totalEndCPU, $demonCPUBaseObject);

            //Calculating points from the simulated demon
            $strLevelUpPointsCPU = $calculated["the_lab_self_demon"]["strCPU"] - $demonCPUBaseObject->getStrDemonBase();
            $endLevelUpPointsCPU = $calculated["the_lab_self_demon"]["endCPU"] - $demonCPUBaseObject->getEndDemonBase();
            $agiLevelUpPointsCPU = $calculated["the_lab_self_demon"]["intCPU"] - $demonCPUBaseObject->getIntDemonBase();
            $intLevelUpPointsCPU = $calculated["the_lab_self_demon"]["agiCPU"] - $demonCPUBaseObject->getAgiDemonBase();
            $lckLevelUpPointsCPU = $calculated["the_lab_self_demon"]["lckCPU"] - $demonCPUBaseObject->getLckDemonBase();

            $demonCPUSimulated->setDemonBase($demonCPUBaseObject);
            $demonCPUSimulated->setStrPoints($strLevelUpPointsCPU);
            $demonCPUSimulated->setEndPoints($endLevelUpPointsCPU);
            $demonCPUSimulated->setAgiPoints($agiLevelUpPointsCPU);
            $demonCPUSimulated->setIntPoints($intLevelUpPointsCPU);
            $demonCPUSimulated->setLckPoints($lckLevelUpPointsCPU);

            //calculating realistic damage with builtin theoric
            $dmgDone = $skillObject->dmgCalcSimulated($demonPlayerSimulated, $demonCPUSimulated, false, $dmgPlayer['percentage']);
        }
        else
        {
            $demonCPUSimulated = null;
            $maxHpSimulatedCPU = null;
            $levelCPUSimulated = null;
            $dmgDone = null;
        }

        return 
        [
            'dmgPlayer' => $dmgPlayer, 
            'demonPlayer' => $demonPlayerSimulated,
            'maxHp' =>  $maxHpSimulated,
            'demonCPU' => $demonCPUSimulated,
            'maxHpCPU' => $maxHpSimulatedCPU,
            'levelCPU' => $levelCPUSimulated,
            'trueDmg' => $dmgDone,
        ];
    }
    
}