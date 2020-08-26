<?php


namespace App\Tests\Service;

use App\Services\Mailer;
use Monolog\Test\TestCase;
use Symfony\Component\Mailer\MailerInterface;

//use Symfony\Component\Mailer\MailerInterface;

class MailerTest extends TestCase
{

    public function testSend()
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $sujet = 'sujet de test';
        $adminEmail = 'nicodupblog@gmail.com';
        $userEmail = 'nicodupblog@gmail.com';
        $render = "ceci est un test";

        $mailer = new Mailer($adminEmail, $symfonyMailer);
        $mail = $mailer->setMessage(
            $sujet,
            $userEmail,
            $render
        );

        $mail->

        //$this->assertEquals($result, $slugString);


        //decoupe et test les 4 variables

    }

}