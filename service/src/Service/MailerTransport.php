<?php

namespace App\Service;

use Garlic\Bus\Service\CommunicatorService;
use Garlic\User\Service\MailerTransportInterface;

/**
 * Class MailerTransport
 */
class MailerTransport implements MailerTransportInterface
{
    const CONFIRMATION_TEMPLATE = 'confirmation-email';
    const RESETTING_TEMPLATE = 'resetting-email';
    const GOOGLE_ACCESS_TOKEN_TEMPLATE = 'google-access-token-email';

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var string
     */
    private $project;

    /**
     * @var CommunicatorService
     */
    private $communicator;

    /**
     * MailerTransport constructor.
     *
     * @param CommunicatorService $communicator
     * @param string              $fromEmail
     * @param string              $project
     */
    public function __construct(
        CommunicatorService $communicator,
        string $fromEmail,
        string $project
    ) {
        $this->fromEmail = $fromEmail;
        $this->project = $project;
        $this->communicator = $communicator;
    }

    /**
     * Send template email
     *
     * @param string      $templateId
     * @param array       $vars
     * @param string      $toEmail
     * @param string|null $fromEmail
     *
     * @param null        $locale
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendTemplate(
        string $templateId,
        array $vars,
        string $toEmail,
        string $fromEmail = null,
        $locale = null
    ) {
        $fromEmail = $fromEmail ?: $this->fromEmail;
        $requestParameters = [
            'templateId'   => $templateId,
            'templateVars' => $vars,
            'fromEmail'    => $fromEmail,
            'toEmail'      => $toEmail,
            'project'      => $this->project,
        ];

        if (!empty($locale)) {
            $requestParameters['locale'] = $locale;
        }

        return $this->communicator
            ->command('message')
            ->post()
            ->mailTemplate(
                [],
                $requestParameters
            );
    }
}
