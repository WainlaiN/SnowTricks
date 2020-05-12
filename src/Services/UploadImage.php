<?php


namespace App\Services;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;


class UploadImage
{
    public function saveImage(Image $image, $path): Image
    {
        // Récupère le fichier de l'image uploadée
        $file = $image->getFile();

        // Créer un nom unique pour le fichier
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        // Déplace le fichier
        $file->move(
            $path,
            $filename
        );

        //$image->set($uploads_directory);
        //$image->setFile($filename);
        $image->setImageFilename($filename);

        return $image;

    }


}