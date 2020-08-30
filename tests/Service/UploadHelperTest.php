<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Services\UploadHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelperTest extends TestCase
{

    public function testSaveImage()
    {
        $uploadHelper = $this->createMock(UploadHelper::class);
        $photo = new UploadedFile(
            '/Uploads/photo.png',
            'photo.png',
            'image/png',
            null
        );
        dump($photo);

        $uploadHelper->saveMainFile($photo);


    }
}
