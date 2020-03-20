<?php

namespace Drixs6o9\SendinblueMailerBundle\Tests\Transport;

use Drixs6o9\SendinblueMailerBundle\Transport\SendinblueSmtpsTransport;
use Drixs6o9\SendinblueMailerBundle\Transport\SendinblueSmtpTransport;
use Drixs6o9\SendinblueMailerBundle\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Test\TransportFactoryTestCase;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportFactoryInterface;

/**
 * Class SeninblueTransportFactoryTest.
 *
 * @author Yann LUCAS
 */
class SeninblueTransportFactoryTest extends TransportFactoryTestCase
{
    /**
     * {@inheritDoc}
     */
    public function getFactory(): TransportFactoryInterface
    {
        return new SendinblueTransportFactory($this->getDispatcher(), $this->getClient(), $this->getLogger());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsProvider(): iterable
    {
        yield [
            new Dsn('sendinblue', 'default'),
            true,
        ];

        yield [
            new Dsn('sendinblue+smtp', 'default'),
            true,
        ];

        yield [
            new Dsn('sendinblue+smtps', 'default'),
            true,
        ];

        yield [
            new Dsn('sendinblue+smtp', 'example.com'),
            true,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function createProvider(): iterable
    {
        yield [
            new Dsn('sendinblue', 'default', self::USER, self::PASSWORD),
            new SendinblueSmtpTransport(self::USER, self::PASSWORD, $this->getDispatcher(), $this->getLogger()),
        ];

        yield [
            new Dsn('sendinblue+smtp', 'default', self::USER, self::PASSWORD),
            new SendinblueSmtpTransport(self::USER, self::PASSWORD, $this->getDispatcher(), $this->getLogger()),
        ];

        yield [
            new Dsn('sendinblue+smtps', 'default', self::USER, self::PASSWORD),
            new SendinblueSmtpsTransport(self::USER, self::PASSWORD, $this->getDispatcher(), $this->getLogger()),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function unsupportedSchemeProvider(): iterable
    {
        yield [
            new Dsn('sendinblue+foo', 'default', self::USER, self::PASSWORD),
            'The "sendinblue+foo" scheme is not supported; supported schemes for mailer "sendinblue" are: "sendinblue", "sendinblue+smtp", "sendinblue+smtps".',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function incompleteDsnProvider(): iterable
    {
        yield [new Dsn('sendinblue+smtp', 'default', self::USER)];

        yield [new Dsn('sendinblue+smtp', 'default', null, self::PASSWORD)];
    }
}
