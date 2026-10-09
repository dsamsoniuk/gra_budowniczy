<?php
// src/Message/CreateArticleMessage.php
namespace App\Message;

class GrantRewardMessage
{
    public function __construct(private int $userId) {
    }
    public function getuserId(){
        return $this->userId;
    }
}