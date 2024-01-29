<?php

namespace App\Service;

use App\Entity\DemonTrait;
use App\Repository\DemonTraitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraitGenerator extends AbstractController
{

    private DemonTraitRepository $demonTraitRepository;
    public function __construct(DemonTraitRepository $demonTraitRepository)
    {
        $this->demonTraitRepository = $demonTraitRepository;
    }

    public function traitGenerator() : DemonTrait
    {
        $traits = $this->demonTraitRepository->findBy([], ["name" => "ASC"]); 
        $pickedTrait = array_rand($traits);
        return $traits[$pickedTrait];
    }
}