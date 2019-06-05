<?php

namespace Drixs6o9\SendinblueMailerBundle\Transport;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class SendinblueSmtpTransport.
 *
 * @author Yann LUCAS
 */
final class SendinblueSmtpTransport extends EsmtpTransport
{
    const SENDINBLUE_SMTP_HOST = 'smtp-relay.sendinblue.com';
    const SENDINBLUE_SMTP_PORT = 465;
    const SENDINBLUE_TLS_ENABLED = true;

    /**
     * SendinblueSmtpTransport constructor.
     *
     * @param string                        $username
     * @param string                        $password
     * @param EventDispatcherInterface|null $dispatcher
     * @param LoggerInterface|null          $logger
     */
    public function __construct($username, $password, $dispatcher = null, $logger = null)
    {
        parent::__construct(
            self::SENDINBLUE_SMTP_HOST,
            self::SENDINBLUE_SMTP_PORT,
            self::SENDINBLUE_TLS_ENABLED,
            $dispatcher,
            $logger
        );

        $this->setUsername($username);
        $this->setPassword($password);
    }
}
