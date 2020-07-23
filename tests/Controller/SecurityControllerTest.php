<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        //self::assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertResponseIsSuccessful();

    }


}