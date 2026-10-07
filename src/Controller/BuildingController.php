<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\User;
use App\Entity\UserBuilding;
use App\Factory\UserBuildingFactory;
use App\Message\BuildMessage;
use App\Repository\BuildingRepository;
use App\Service\BuildingVerifyService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class BuildingController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em){}

    #[Route('/building', name: 'app_building')]
    public function index(): Response
    {
        return $this->render('building/index.html.twig', [
            'controller_name' => 'BuildingController',
        ]);
    }
    #[Route('/b', name: 'app_buildingb')]
    public function b(): Response
    {
        return $this->render('building/template.html.twig', [
            'controller_name' => 'aaa',
        ]);
    }

    #[Route('/building/list', name: 'app_building_list')]
    public function list(
        BuildingRepository $buildRepo
    ): JsonResponse
    {
        $buildings = $buildRepo->findAllasArray();
        
        return $this->json([
            'avatarPath' => '/avatar/',
            'data' => $buildings,
        ]);
    }

    /**
     * User buildings in construction
     */
    #[Route('/building/user-constructions', name: 'app_building_user_constructions')]
    public function constructions(
        BuildingRepository $buildRepo
    ): JsonResponse
    {
        $user = $this->getUser();
        $buildings = $buildRepo->findBuildings($user, 'construction');

        return $this->json($buildings);
    }
    /**
     * User buildings
     */
    #[Route('/building/user-buildings', name: 'app_building_user_buildings')]
    public function userBuildings(
        BuildingRepository $buildRepo
    ): JsonResponse
    {
        $user = $this->getUser();
        $buildings = $buildRepo->findBuildings($user, 'finished');

        return $this->json($buildings);
    }
    /**
     * Create building
     */
    #[Route('/building/create/{building}', name: 'app_building_create')]
    public function create(
        Building $building,
        MessageBusInterface $bus,
        BuildingVerifyService $buildingVerify
        ): JsonResponse
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $profile = $user->getProfile();

        if ($buildingVerify->canBeBuilded($user, $building)) {

            $newBuilding = UserBuildingFactory::new($user, $building);
            $this->em->persist($newBuilding);

            $profile->setSourceGold($profile->getSourceGold() - $building->getGoldCost());
            $this->em->persist($profile);
            $this->em->flush();

            $timeInSec = $building->getBuildTime();

            $bus->dispatch(new BuildMessage($newBuilding->getId()), [new DelayStamp($timeInSec * 1000)]);

            $message = "Budynek wybudowany";
        } else {
            $message = "Budynek nie zostal wybudowany, sprawdz zasoby";
        }

        return $this->json([
            'message' => $message,
            'time' => $building->getBuildTime()
        ]);
    }
    /**
     * Create building
     */
    #[Route('/building/delete/{userBuilding}', name: 'app_building_delete')]
    public function delete(UserBuilding $userBuilding,): JsonResponse
    {
        $this->em->remove($userBuilding);
        $this->em->flush();

        return $this->json([
            'status' => 'success',
            'message' => "Usunięty",
        ]);
    }
}
