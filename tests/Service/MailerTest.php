<?php


namespace App\Tests\Service;

use App\Services\Mailer;
use Monolog\Test\TestCase;
use Symfony\Component\Mailer\MailerInterface;

//use Symfony\Component\Mailer\MailerInterface;

class MailerTest extends TestCase
{
    private $mailer;

    public function test__construct(Mailer $mailer)
    {
        $this->mailer = $mailer;

    }

    public function testSend()
    {

        $mailer->sendEmail(
            'sujet de test',
            'nicodupblog@gmail.com',
            "Ceci est un email de test"
        );


    }

}