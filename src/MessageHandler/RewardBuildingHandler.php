<?php
// src/MessageHandler/CreateArticleHandler.php
namespace App\MessageHandler;

use App\Entity\Article;
use App\Entity\Notification;
use App\Message\GrantRewardMessage;
use App\Message\RewardForBuilding;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class RewardBuildingHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $bus,
        private UserProfileRepository $profileRepo
    ) {}

    public function __invoke(RewardForBuilding $message): void
    {
        $profiles = $this->profileRepo->findAll();
        foreach ($profiles as $profile) {
            $this->bus->dispatch(new GrantRewardMessage($profile->getUser()->getId()));
        }

        // $article = new Notification();
        // $article->setContent('Automatyczny wpis z dnia: ' . date('Y-m-d H:i:s'));

        // $this->entityManager->persist($article);
        // $this->entityManager->flush();
    }
}
