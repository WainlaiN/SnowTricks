<?php


namespace App\Tests\Service;

use App\Services\Slugify;
use Monolog\Test\TestCase;

class SlugifyTest extends TestCase
{

    public function testSlugify()
    {

        $slugify = new Slugify();
        $string = "Une chaine de caractère à transformer en slug";
        $slugString = "une-chaine-de-caractere-a-transformer-en-slug";
        $result = $slugify->slugify($string);
        $this->assertEquals($result, $slugString);

    }
}