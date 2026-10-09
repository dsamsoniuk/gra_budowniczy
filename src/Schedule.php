<?php

namespace App;

use App\Message\RewardForBuilding;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule as SymfonySchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule('default')] // Definiuje harmonogram o nazwie 'default'
class Schedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getSchedule(): SymfonySchedule
    {
        return (new SymfonySchedule())->add(
            RecurringMessage::every('5 minute', new RewardForBuilding())
            )
            ->stateful($this->cache); // Dodatkowa opcja zapisuje w cache zamiast tylko w RAM
    }
}
