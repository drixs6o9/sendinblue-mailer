<?php

namespace Drixs6o9\SendinblueMailerBundle\Tests\Transport;

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
            new Dsn('smtp', 'sendinblue'),
            true,
        ];

        yield [
            new Dsn('smtp', 'example.com'),
            false,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function createProvider(): iterable
    {
        yield [
            new Dsn('smtp', 'sendinblue', self::USER, self::PASSWORD),
            new SendinblueSmtpTransport(self::USER, self::PASSWORD, $this->getDispatcher(), $this->getLogger()),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function unsupportedSchemeProvider(): iterable
    {
        yield [
            new Dsn('foo', 'sendinblue', self::USER, self::PASSWORD),
            'The "foo" scheme is not supported for mailer "sendinblue". Supported schemes are: "smtp".',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function incompleteDsnProvider(): iterable
    {
        yield [new Dsn('smtp', 'sendinblue', self::USER)];
    }
}
