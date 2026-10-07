<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
    #[Route('/profile/stats', name: 'app_profile_stats')]
    public function stats(): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $profile = $user->getProfile();

        return $this->json([
            'source_gold' => $profile->getSourceGold()
        ]);
    }
}
