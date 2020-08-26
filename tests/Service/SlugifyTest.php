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

        //test a string
        $this->assertEquals($result, $slugString);

        //test some characters
        $this->assertEquals($slugify->slugify("é"), "e");
        $this->assertEquals($slugify->slugify("M"), "m");
        $this->assertEquals($slugify->slugify("ê"), "e");
        $this->assertEquals($slugify->slugify("un espace"), "un-espace");

        //test some special characters
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
        $this->assertEquals($slugify->slugify(implode($special_chars)), "");

    }
}