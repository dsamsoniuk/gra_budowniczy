<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class BuildMessage
{
    public function __construct(
        public readonly int $id_user_build,
    ) {
    }
    public function getId(): int{
        return $this->id_user_build;
    }
}
