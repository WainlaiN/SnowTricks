<?php


namespace App\Tests\Service;

use App\Services\Mailer;
use Monolog\Test\TestCase;
use Symfony\Component\Mailer\MailerInterface;

//use Symfony\Component\Mailer\MailerInterface;

class MailerTest extends TestCase
{

    public function testEmail()
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        //$symfonyMailer->expects($this->once())
        //    ->method('send');

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

        $senderToTest = $mail->getTo();
        $fromToTest = $mail->getFrom();
        $bodyToTest = $mail->getBody()->bodyToString();


        $this->assertEquals($senderToTest['0']->getAddress(), $adminEmail);
        $this->assertEquals($fromToTest['0']->getAddress(), $adminEmail);
        $this->assertEquals($bodyToTest, $render);


    }

}