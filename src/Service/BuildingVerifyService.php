<?php

namespace App\Service;

use App\Entity\Building;
use App\Entity\User;

class BuildingVerifyService {
    public function canBeBuilded(User $user, Building $building): bool{
        $profile = $user->getProfile();
        if ($profile->getSourceGold() < $building->getGoldCost()) {
            return false;
        }
        return true;
    }
}