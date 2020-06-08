<?php

namespace Drixs6o9\SendinblueMailerBundle\Transport;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\HttpTransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractApiTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SendinblueApiTransport extends AbstractApiTransport
{
    private const SENDINBLUE_API_HOST = 'api.sendinblue.com';

    private $key;

    public function __construct(string $key, ?HttpClientInterface $client = null, ?EventDispatcherInterface $dispatcher = null, ?LoggerInterface $logger = null)
    {
        $this->key = $key;

        parent::__construct($client, $dispatcher, $logger);
    }

    public function __toString(): string
    {
        return sprintf('sendinblue+api://%s', $this->getEndpoint());
    }

    protected function doSendApi(SentMessage $sentMessage, Email $email, Envelope $envelope): ResponseInterface
    {
        $response = $this->client->request('POST', 'https://'.$this->getEndpoint().'/v3/smtp/email', [
            'json' => $this->getPayload($email, $envelope),
            'headers' => [
                'api-key' => $this->key
            ],
        ]);

        $result = $response->toArray(false);
        if (201 !== $response->getStatusCode()) {
            throw new HttpTransportException('Unable to send an email: '.$result['message'].sprintf(' (code %d).', $response->getStatusCode()), $response);
        }

        $sentMessage->setMessageId($result['messageId']);

        return $response;
    }

    private function getPayload(Email $email, Envelope $envelope): array
    {
        $addressStringifier = function (Address $address) {
            $stringified = ['email' => $address->getAddress()];

            if ($address->getName()) {
                $stringified['name'] = $address->getName();
            }

            return $stringified;
        };

        $payload = [
            'sender' => $addressStringifier($envelope->getSender()),
            "subject" => $email->getSubject()
        ];

        // CC
        if ($emails = array_map($addressStringifier, $email->getCc())) {
            $payload['cc'] = $emails;
        }

        // BCC
        if ($emails = array_map($addressStringifier, $email->getBcc())) {
            $payload['bcc'] = $emails;
        }

        // ReplyTo
        if ($emails = array_map($addressStringifier, $email->getReplyTo())) {
            $payload['replyTo'] = $emails;
        }

        // Body
        if (null !== $email->getTextBody()) {
            $payload['textContent'] = $email->getTextBody();
        }
        if (null !== $email->getHtmlBody()) {
            $payload['htmlContent'] = $email->getHtmlBody();
        }

        // Attachments
        if ($email->getAttachments()) {
            $payload['attachment'] = $this->getAttachments($email);
        }

        return $payload;
    }

    private function getAttachments(Email $email): array
    {
        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $headers = $attachment->getPreparedHeaders();
            $filename = $headers->getHeaderParameter('Content-Disposition', 'filename');

            $att = [
                'content' => str_replace("\r\n", '', $attachment->bodyToString()),
                'name' => $filename,
            ];

            $attachments[] = $att;
        }

        return $attachments;
    }

    private function getEndpoint(): ?string
    {
        return ($this->host ?: self::HOST).($this->port ? ':'.$this->port : '');
    }
}
