<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ImageManagementService
{
    private ?string $targetDirectory = null;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * Allows to secure form with uploaded content, checking if the uploaded file is an image as intended
     *
     * @param string $fileName
     * @return bool
     */
    public function isFileAnImage(string $fileName): bool
    {
        $regex = "/\.(jpeg|jpg|png|gif|svg)$/";
        return preg_match($regex, $fileName);
    }

    public function deleteAnImageFromTheUploadDirectory(string $imageName)
    {
        $fileSystem = new Filesystem();

        $completePath = $this->getTargetDirectory() . '/' . $imageName;

        $fileSystem->remove($completePath);
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}