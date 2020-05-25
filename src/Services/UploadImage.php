<?php


namespace App\Services;

use App\Entity\Image;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class UploadImage
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

        //récupère le repertoire image
        $destination = $this->uploadPath;

        // Récupère le fichier de l'image uploadée
        $file = $image->getFile();

        // Créer un nom unique pour le fichier
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        // Déplace le fichier
        $file->move(
            $destination,
            $filename
        );

        $image->setImageFilename($filename);

        return $image;

    }


}