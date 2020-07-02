<?php


namespace App\Services;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{

    private $mailer;
    /**
     * @var string
     */
    private $adminEmail;

    public function __construct(string $adminEmail, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function sendEmail($subject, $to, $render)
    {

        $message = (new Email())
            ->subject($subject)
            ->from($this->adminEmail)
            ->to($to)
            ->html($render);

        $this->mailer->send($message);
    }

}