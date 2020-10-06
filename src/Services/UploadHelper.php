<?php

namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Class UploadHelper
 *
 * @package App\Services
 */
class UploadHelper
{
    /**
     *
     */
    const IMAGE_DIR = '/images/';
    //const IMAGE_DIR_MAIN = '/images/main/';
    /**
     *
     */
    const PICTURE_DIR = '/pictures/';
    /**
     * @var string
     */
    private $uploadPath;

    /**
     * UploadHelper constructor.
     *
     * @param string $uploadPath
     */
    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * @param $image
     * @return Image
     */
    public function saveImage($image): Image
    {
        $filename = $this->moveFile($this->uploadPath.self::IMAGE_DIR, $image);
        $image->setImageFilename($filename);

        return $image;
    }

    /**
     * @param File $file
     * @return string
     */
    public function saveMainFile(File $file)
    {
        return $this->moveFile($this->uploadPath.self::IMAGE_DIR, $file);
    }

    /**
     * @param File $file
     * @return string
     */
    public function savePicture(File $file)
    {
        return $this->moveFile($this->uploadPath.self::PICTURE_DIR, $file);
    }

    /**
     * @param $file
     * @return string
     */
    private function renameFile($file)
    {
        return md5(uniqid()).'.'.$file->guessExtension();
    }

    /**
     * @param $destination
     * @param File $file
     * @return string
     */
    private function moveFile($destination, File $file)
    {
        $filename = $this->renameFile($file);
        $file->move($destination, $filename);

        return $filename;
    }
}