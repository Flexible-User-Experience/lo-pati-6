<?php

namespace App\Event\Listener;

use App\Entity\User;
use App\Event\UserSuccessLoginEvent;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserSuccessLoginEventListener
{
    public function __construct(private EntityManagerInterface $em) {}

    public function onUserSuccessLogin(UserSuccessLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        $user
            ->setLastLogin(new DateTimeImmutable())
            ->addLoginCount()
        ;
        $this->em->flush();
    }
}
