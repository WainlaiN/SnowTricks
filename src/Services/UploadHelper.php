<?php


namespace App\Services;

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


}