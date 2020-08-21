<?php


namespace App\Tests\Service;

use App\Services\Slugify;
use Monolog\Test\TestCase;

class SlugifyTest extends TestCase
{

    public function testSlugify()
    {
        $slugify = $this->createMock(Slugify::class);
        $string = "Une chaine de caractère à transformer en slug";
        $slugify->method('slugify');



    }
}