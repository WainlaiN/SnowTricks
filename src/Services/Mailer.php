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

    public function setMessage($subject, $to, $render, $send = false)
    {
        $email = new Email();
        $email->subject($subject)
            ->from($this->adminEmail)
            ->to($to)
            ->html($render);

        if ($send == false) {

            return $email;
        }

        $this->sendEmail($email);
    }

    private function sendEmail($email)
    {
        $this->mailer->send($email);
    }

}