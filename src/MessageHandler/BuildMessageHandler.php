<?php

namespace App\MessageHandler;

use App\Entity\UserBuilding;
use App\Message\BuildMessage;
use App\Repository\UserBuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BuildMessageHandler{
    public function __construct(
        private UserBuildingRepository $ubRepo,
        private EntityManagerInterface $em
    ){}
    public function __invoke(BuildMessage $message): void
    {
        /**
         * @var UserBuilding
         */
        $userBuilding = $this->ubRepo->find($message->getId());
        $userBuilding->setStatus('finished');

        $this->em->persist($userBuilding);
        $this->em->flush();
        // do something with your message
    }
}
