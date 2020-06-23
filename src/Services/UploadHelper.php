<?php

namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const IMAGE_DIR = '/uploads/images/';
    const PICTURE_DIR = '/uploads/pictures/';
    /**
     * @var string
     */
    private $uploadPath;
    /**
     * @var string
     */
    private $uploadPicture;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;

    }

    public function saveImage($image): Image
    {

        //get the image directory
        $destination = $this->uploadPath.self::IMAGE_DIR;
        // get the uploaded file from the Image object
        $file = $image->getFile();
        // set a filename
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        // move the file
        $file->move(
            $destination,
            $filename
        );
        //set the new filename to image
        $image->setImageFilename($filename);

        return $image;
    }

    public function saveMainFile(File $file)
    {
        //get the image directory
        $destination = $this->uploadPath.self::IMAGE_DIR;
        // set a filename
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        // move the file
        $file->move(
            $destination,
            $filename
        );

        return $filename;
    }

    public function savePicture(File $file)
    {
        //get the Picture directory
        $destination = $this->uploadPath.self::PICTURE_DIR;
        // set a filename
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        // move the file
        $file->move(
            $destination,
            $filename
        );

        return $filename;
    }
}