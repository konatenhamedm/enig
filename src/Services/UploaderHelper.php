<?php

namespace App\Services;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderHelper
{

    private $uploadsPath;
    private $targetDir;
    private $slugger;

    public function __construct(string $uploadsPath,$targetDir,SluggerInterface $slugger)
    {
        $this->uploadsPath = $uploadsPath;
        $this->targetDir = $targetDir;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file) {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getTargetDir(), $fileName);
        return $fileName;
    }

    public function getTargetDir() {
        return $this->targetDir;
    }

    public function uploadImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath . '/images';
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $fileName
        );

        return $fileName;
    }
}
