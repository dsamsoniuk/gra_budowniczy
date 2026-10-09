<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserBuildingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(
        MessageBusInterface $bus,
        UserBuildingRepository $ubr
    ): Response
    {
        /**
         * @var User
         */
        $u = $this->getUser();
        $res = $ubr->getSumBuildingsProfit($u->getId());
        dump($res);
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
