<?php

namespace App\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;

class BrevoTransport extends AbstractTransport
{
    public function __construct(protected string $apiKey)
    {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = [
            'sender' => $this->formatAddress($email->getFrom()[0] ?? null),
            'to'     => $this->formatAddresses($email->getTo()),
            'subject' => $email->getSubject(),
        ];

        if ($cc = $email->getCc())   $payload['cc']  = $this->formatAddresses($cc);
        if ($bcc = $email->getBcc()) $payload['bcc'] = $this->formatAddresses($bcc);
        if ($reply = $email->getReplyTo()) {
            $payload['replyTo'] = $this->formatAddress($reply[0]);
        }

        if ($html = $email->getHtmlBody()) $payload['htmlContent'] = $html;
        if ($text = $email->getTextBody()) $payload['textContent'] = $text;

        // Attachments
        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $headers = $attachment->getPreparedHeaders();
            $filename = $headers->getHeaderParameter('Content-Disposition', 'filename')
                ?? 'attachment';

            $attachments[] = [
                'name'    => $filename,
                'content' => base64_encode($attachment->getBody()),
            ];
        }
        if ($attachments) $payload['attachment'] = $attachments;

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept'  => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Brevo API error: ' . $response->status() . ' ' . $response->body()
            );
        }
    }

    protected function formatAddress($address): ?array
    {
        if (! $address) return null;
        return array_filter([
            'email' => $address->getAddress(),
            'name'  => $address->getName() ?: null,
        ]);
    }

    protected function formatAddresses(array $addresses): array
    {
        return array_map(fn($a) => $this->formatAddress($a), $addresses);
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
