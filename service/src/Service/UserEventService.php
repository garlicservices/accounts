<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\UserEvent;
use App\Entity\User;

class UserEventService
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * UserEventLoggerSubscriber constructor.
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create user event
     *
     * @param User       $user
     * @param string     $eventName
     * @param array|null $data
     */
    public function create(User $user, string $eventName, array $data = null)
    {
        $userEvent = new UserEvent();
        $userEvent
            ->setUser($user)
            ->setName($eventName);

        if (!empty($data)) {
            $userEvent->setData($data);
        }

        $this->entityManager->persist($userEvent);
        $this->entityManager->flush();
    }
}
