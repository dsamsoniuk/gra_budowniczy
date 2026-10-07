<?php

namespace App\Factory;

use App\Entity\Building;
use App\Entity\User;
use App\Entity\UserBuilding;
use DateTime;

class UserBuildingFactory {
    public static function new(User $user, Building $building){
        $finishTime = new DateTime();
        $timeInSec = $building->getBuildTime();
        $finishTime->modify("+$timeInSec seconds");

        $newBuilding = new UserBuilding();
        $newBuilding->setUser($user);
        $newBuilding->setBuilding($building);
        $newBuilding->setFinishTime($finishTime);
        return $newBuilding;
    }
}