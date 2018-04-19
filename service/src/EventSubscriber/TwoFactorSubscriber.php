<?php

namespace App\EventSubscriber;

use App\Service\MailerService;
use App\Event\TwoFactorAuthenticationEvent;
use App\Event\TwoFactorAuthenticationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TwoFactorSubscriber
 */
class TwoFactorSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    private $mailerService;

    /**
     * TwoFactorSubscriber constructor.
     *
     * @param MailerService $mailerService
     */
    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            TwoFactorAuthenticationEvents::ACTIVATE_SUCCESS => 'onActivateSuccess',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onActivateSuccess(TwoFactorAuthenticationEvent $event)
    {
        $request = $event->getRequest();
        if ($request instanceof Request && $request->request->get('send_to_email')) {
            $this->mailerService->sendTwoFactorActivateSuccessMessage($event->getUser());
        }
    }
}
