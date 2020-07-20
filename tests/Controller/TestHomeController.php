<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestHomeController extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->getRequest();
        self::assertEquals(200, $client->getResponse()->getStatusCode());

    }

}