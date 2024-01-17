<?php
namespace App\Service;

class LevelCalculator
{
    public static function calculateLevel(int $xp) : int
    {
        $baseLevel = 1;
        $xpNeeded = 500;

        while ($baseLevel <= 30 && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.05);
            $xp = $xp - $xpNeeded;
        }
        while ( ($baseLevel >= 31  && $baseLevel <= 50) && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.075);
            $xp = $xp - $xpNeeded;
        }
        while ( ( $baseLevel >= 51 && $baseLevel <= 90)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.1);
            $xp = $xp - $xpNeeded;
        }
        while (($baseLevel  >= 91 && $baseLevel< 100)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.2);
            $xp = $xp - $xpNeeded;
        }

        return $baseLevel;
    }

    public static function calculateLevelPercentage(int $xp) : array
    {
        $baseLevel = 1;
        $xpNeeded = 500;

        while ($baseLevel <= 30 && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.05);
            $xp = $xp - $xpNeeded;
        }
        while ( ($baseLevel >= 31  && $baseLevel <= 50) && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.075);
            $xp = $xp - $xpNeeded;
        }
        while ( ( $baseLevel >= 51 && $baseLevel <= 90)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.1);
            $xp = $xp - $xpNeeded;
        }
        while (($baseLevel  >= 91 && $baseLevel< 100)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.2);
            $xp = $xp - $xpNeeded;
        }
        $percentageXp = ($xp / $xpNeeded) * 100;
        return [ "xp" => $xp, "xpNeeded" => $xpNeeded, "percentage" => $percentageXp];
    }

    public static function calcMaxHP($totalEnd, $baseHp, $level)
    {
        $maxHP = ($totalEnd * 3) + $baseHp + 1 * $level;
        return $maxHP;
    }
}