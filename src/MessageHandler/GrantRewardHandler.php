<?php
// src/MessageHandler/CreateArticleHandler.php
namespace App\MessageHandler;

use App\Entity\User;
use App\Message\GrantRewardMessage;
use App\Repository\UserBuildingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GrantRewardHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserBuildingRepository $userBuildingRepo,
        private UserRepository $userRepo
    ) {}

    public function __invoke(GrantRewardMessage $message): void
    {
        $goldProfits = $this->userBuildingRepo->getSumBuildingsProfit($message->getuserId());
        /**
         * @var User
         */
        $user = $this->userRepo->find($message->getuserId());
        $profile = $user->getProfile();

        $profile->setSourceGold($profile->getSourceGold() + $goldProfits);

        $this->entityManager->persist($profile);
        $this->entityManager->flush();
    }
}
