<?php

namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const IMAGE_DIR = '/images/';
    const PICTURE_DIR = '/pictures/';
    /**
     * @var string
     */
    private $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;

    }

    public function saveImage($image): Image
    {

        $destination = $this->uploadPath.self::IMAGE_DIR;
        $file = $image->getFile();
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $destination,
            $filename
        );

        $image->setImageFilename($filename);

        return $image;
    }

    public function saveMainFile(File $file)
    {
        $destination = $this->uploadPath.self::IMAGE_DIR;
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $destination,
            $filename
        );

        return $filename;
    }

    public function savePicture(File $file)
    {
        $destination = $this->uploadPath.self::PICTURE_DIR;
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
            $destination,
            $filename
        );

        return $filename;
    }
}