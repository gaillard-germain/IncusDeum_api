<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
  private $targetDirectory;
  private $slugger;

  public function __construct($targetDirectory, SluggerInterface $slugger)
  {
    $this->targetDirectory = $targetDirectory;
    $this->slugger = $slugger;
  }

  public function upload(UploadedFile $file)
  {
    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $safeFilename = $this->slugger->slug($originalFilename);
    $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    $fileSize = $file->getSize();
    $fileType = $file->getMimeType();
    $fileUrl = "http://localhost:8000/images/".$fileName;

    try {
        $file->move($this->getTargetDirectory(), $fileName);
    } catch (FileException $e) {
        // ... handle exception if something happens during file upload
    }

    return [
      "name" => $fileName,
      "size" => $fileSize,
      "type" => $fileType,
      "url" => $fileUrl
    ];
  }

  public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}