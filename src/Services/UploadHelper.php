<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const IMAGEDIR = '/uploads/images';
    const PICTUREDIR = '/uploads/pictures';
    /**
     * @var string
     */
    private $uploadPath;

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = $uploadPath;

    }

    public function saveImage($image)
    {

        //get the image directory
        $destination = $this->uploadPath.self::IMAGEDIR;
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

    public function saveMainFile(UploadedFile $uploadedFile)
    {
        //get the image directory
        $destination = $this->uploadPath.self::IMAGEDIR;
        // set a filename
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        // move the file
        $uploadedFile->move(
            $destination,
            $filename
        );

        return $filename;
    }

    public function savePicture(UploadedFile $uploadedFile)
    {
        //get the Picture directory
        $destination = $this->uploadPath.self::PICTUREDIR;
        // set a filename
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        // move the file
        $uploadedFile->move(
            $destination,
            $filename
        );

        return $filename;
    }
}