<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Services\UploadHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelperTest extends TestCase
{
    /**public function testSomething()
    {
        $this->assertTrue(true);
    }**/


    public function testSaveImage ()
    {
        $photo = new UploadedFile(
            '',
            'photo.jpg',
            'image/jpeg',
            null
        );

        $uploadHelper = new UploadHelper("test");

    }
}
