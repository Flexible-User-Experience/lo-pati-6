<?php

namespace App\Event;

use Symfony\Component\Security\Core\User\UserInterface;

final readonly class UserSuccessLoginEvent
{
    public const string NAME = 'app.user_success_login_event';

    public function __construct(private UserInterface $user) {}

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
