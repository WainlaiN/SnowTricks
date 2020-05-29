<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
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
        $destination = $this->uploadPath;
        // get the uploaded file
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
        $destination = $this->uploadPath;
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