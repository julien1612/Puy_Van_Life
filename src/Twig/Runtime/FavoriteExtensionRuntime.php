<?php

namespace App\Twig\Runtime;


use App\Entity\Location;
use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class FavoriteExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    //2
    public function isLocationFavorite(?User $user, ?Location $location): bool
    {
        if ($user === null || $location === null) {
            return false;
        }

        foreach ($user->getFavoriteLocations() as $favoriteLocation) {
            if ($favoriteLocation->getLocation()->getId() === $location->getId()) {
                return true;
            }
        }

        return false;
    }
}
