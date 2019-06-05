<?php

namespace Drixs6o9\SendinblueMailerBundle\Transport;

use Symfony\Component\Mailer\Exception\UnsupportedSchemeException;
use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportInterface;

/**
 * Class SendinblueTransportFactory.
 *
 * @author Yann LUCAS
 */
final class SendinblueTransportFactory extends AbstractTransportFactory
{
    /**
     * {@inheritDoc}
     */
    public function create(Dsn $dsn): TransportInterface
    {
        if ('smtp' !== $dsn->getScheme()) {
            throw new UnsupportedSchemeException($dsn, ['smtp']);
        }

        return new SendinblueSmtpTransport(
            $this->getUser($dsn),
            $this->getPassword($dsn),
            $this->dispatcher,
            $this->logger
        );
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Dsn $dsn): bool
    {
        return 'sendinblue' === $dsn->getHost();
    }
}
