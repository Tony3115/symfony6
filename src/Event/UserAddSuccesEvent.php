<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserAddSuccessEvent extends Event
{
    public function __construct(private User $user) {}

    public function getUser(): User
    {
        return $this->user;
    }
}
