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

    private function setMessage($subject, $to, $render)
    {
        $email = new Email();
        $email->subject($subject)
            ->from($this->adminEmail)
            ->to($to)
            ->html($render);

        return $email;
    }

    public function sendEmail($subject, $to, $render)
    {
        $this->mailer->send($this->setMessage($subject, $to, $render));
    }

}