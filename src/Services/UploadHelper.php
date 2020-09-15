<?php

namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;


class UploadHelper
{
    const IMAGE_DIR = '/images/';
    //const IMAGE_DIR_MAIN = '/images/main/';
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
        $filename = $this->moveFile($this->uploadPath.self::IMAGE_DIR, $image);
        $image->setImageFilename($filename);

        return $image;
    }

    public function saveMainFile(File $file)
    {
        return $this->moveFile($this->uploadPath.self::IMAGE_DIR, $file);
    }

    public function savePicture(File $file)
    {
        return $this->moveFile($this->uploadPath.self::PICTURE_DIR, $file);
    }

    private function renameFile($file)
    {
        return md5(uniqid()).'.'.$file->guessExtension();
    }

    private function moveFile($destination, File $file)
    {
        $filename = $this->renameFile($file);
        $file->move($destination, $filename);

        return $filename;
    }
}