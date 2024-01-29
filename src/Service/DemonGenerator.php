<?php
namespace App\Service;

use App\Entity\DemonPlayer;
use App\Service\TraitGenerator;
use App\Repository\BattleRepository;
use App\Repository\PlayerRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use App\Repository\SkillTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemonGenerator extends AbstractController
{
    private PlayerRepository $playerRepository;
    private BattleRepository $battleRepository;
    private TraitGenerator $traitGenerator;
    private DemonBaseRepository $demonBaseRepository;
    private SkillTableRepository $skillsTableRepo;
    private DemonTraitRepository $demonTraitRepository;
    private EntityManagerInterface $em;

    public function __construct(PlayerRepository $playerRepository,
     BattleRepository $battleRepository, DemonBaseRepository $demonBaseRepository,
      SkillTableRepository $skillsTableRepo, DemonTraitRepository $demonTraitRepository,
       EntityManagerInterface $em, TraitGenerator $traitGenerator)
    {
        $this->playerRepository = $playerRepository;
        $this->battleRepository = $battleRepository;
        $this->demonBaseRepository = $demonBaseRepository;
        $this->skillsTableRepo = $skillsTableRepo;
        $this->demonTraitRepository = $demonTraitRepository;
        $this->em = $em;
        $this->traitGenerator = $traitGenerator;
    }

    public function cpuDemonGen(string $string, ?int $experience) : DemonPlayer
    {
        $trait = $this->traitGenerator->traitGenerator();
        //This is the base template
        $randomDemonCPU = $this->demonBaseRepository->findOneBy(["name" => $string]);
        $cpu = $this->playerRepository->findOneBy(["username" => "CPU"]);
        $demonCPU = new DemonPlayer; //create a demon        
        if ($experience) $demonCPU->setExperience($experience);
        $levelDemon = $demonCPU->getLevel();
        $skillsTable = $this->skillsTableRepo->findSkillsBelowOrEqualToLevel($levelDemon, $randomDemonCPU->getId());
        // $skillsTable = $this->skillsTableRepo->findBy(["demonBase" => $randomDemonCPU->getId()], ["id" => "ASC"]);
        //Pick 6 skills from all the skills the Demon can gain from leveling
        if (count($skillsTable) > 6)
        {
            $randSetOfSkills = array_rand($skillsTable, 6);
            $skillsTable = $randSetOfSkills;
        }
        $demonCPU->setDemonBase($randomDemonCPU); //set base template
        $demonCPU->setTrait($trait); //generate a trait
        foreach ($skillsTable as $skillTable) //it gives the id in the skill table but so we need to getskill
        {
            $skill = $skillTable->getSkill();
            $demonCPU->addSkill($skill);
        }
        $cpu->addDemonPlayer($demonCPU);
        $this->em->persist($demonCPU);
        $this->em->flush();
        return $demonCPU;
    }
}