<?php

namespace App\Service;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Garlic\User\Service\MailerTransportInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class MailerService
 */
class MailerService implements MailerInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var MailerTransport
     */
    private $transport;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    /**
     * MailerService constructor.
     *
     * @param RouterInterface          $router
     * @param MailerTransportInterface $transport
     * @param RequestStack             $requestStack
     */
    public function __construct(
        RouterInterface $router,
        MailerTransportInterface $transport,
        RequestStack $requestStack
    ) {
        $this->router = $router;
        $this->transport = $transport;
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $url = $user->getConfirmationUrl().$user->getConfirmationToken();

        return $this->transport->sendTemplate(
            MailerTransport::CONFIRMATION_TEMPLATE,
            [
                'user_name'        => $user->getUsername(),
                'confirmation_url' => $url,
            ],
            $user->getEmailCanonical(),
            null,
            $this->request->getLocale()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $url = $user->getConfirmationUrl().$user->getConfirmationToken();

        return $this->transport->sendTemplate(
            MailerTransport::RESETTING_TEMPLATE,
            [
                'user_name' => $user->getUsername(),
                'reset_url' => $url,
            ],
            $user->getEmailCanonical(),
            null,
            $this->request->getLocale()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sendTwoFactorActivateSuccessMessage(UserInterface $user)
    {
        return $this->transport->sendTemplate(
            MailerTransport::GOOGLE_ACCESS_TOKEN_TEMPLATE,
            [
                'user_name'           => $user->getUsername(),
                'google_access_token' => $user->getGoogleAccessToken(),
            ],
            $user->getEmailCanonical(),
            null,
            $this->request->getLocale()
        );
    }
}
