<?php

namespace App\EventSubscriber;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use App\Service\UserEventService;
use App\ServiceBundle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserEventLoggerSubscriber
 */
class UserEventLoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserEventService
     */
    private $userEventService;

    /**
     * UserEventLoggerSubscriber constructor.
     *
     * @param UserEventService $userEventService
     */
    public function __construct(UserEventService $userEventService)
    {
        $this->userEventService = $userEventService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_CONFIRM => 'onSuccessEmailConfirmation',
        ];
    }

    /**
     * Save event on success email confirmation
     *
     * @param GetResponseUserEvent $event
     */
    public function onSuccessEmailConfirmation(GetResponseUserEvent $event)
    {
        $this->userEventService->create($event->getUser(), 'email_confirmed');
    }
}
