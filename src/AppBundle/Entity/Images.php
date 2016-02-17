<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Images
{
    /**
     * @var UploadedFile[]
     */
    private $files;

    /**
     * @return UploadedFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param UploadedFile[] $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }
}
