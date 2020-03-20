<?php

namespace Drixs6o9\SendinblueMailerBundle\Transport;

use Symfony\Component\Mailer\Exception\TransportException;
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
    const NAMESPACE = 'Drixs6o9\SendinblueMailerBundle\Transport\%s';

    /**
     * {@inheritDoc}
     */
    public function create(Dsn $dsn): TransportInterface
    {
        if (!\in_array($dsn->getScheme(), $this->getSupportedSchemes())) {
            throw new UnsupportedSchemeException($dsn, 'sendinblue', $this->getSupportedSchemes());
        }

        switch ($dsn->getScheme()) {
            default:
            case 'sendinblue':
            case 'sendinblue+smtp':
                $transport = sprintf(self::NAMESPACE, 'SendinblueSmtpTransport');
                break;
            case 'sendinblue+smtps':
                $transport = sprintf(self::NAMESPACE, 'SendinblueSmtpsTransport');
                break;
        }

        return new $transport(
            $this->getUser($dsn),
            $this->getPassword($dsn),
            $this->dispatcher,
            $this->logger
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getSupportedSchemes(): array
    {
        return ['sendinblue', 'sendinblue+smtp', 'sendinblue+smtps'];
    }
}
