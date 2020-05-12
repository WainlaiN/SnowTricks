<?php


namespace App\Service;

use App\Entity\Image;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class UploadImage extends Extension
{
    public function saveImage(Image $image): Image
    {
        $file = $image->getFile();
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        $uploads_directory = $this->getParameter('uploads-directory');
        $file->move(
            $uploads_directory,
            $filename
        );

        //$image->se


    }


}