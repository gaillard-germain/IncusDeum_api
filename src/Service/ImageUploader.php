<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\MediaRepository;

class ImageUploader
{
  private $targetDirectory;
  private $slugger;
  private $mediaRepository;

  public function __construct($targetDirectory, SluggerInterface $slugger, MediaRepository $mediaRepository)
  {
    $this->targetDirectory = $targetDirectory;
    $this->slugger = $slugger;
    $this->mediaRepository = $mediaRepository;
  }

  public function upload(UploadedFile $file)
  {
    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $safeFilename = $this->slugger->slug($originalFilename);
    $fileSize = $file->getSize();
    $fileType = $file->getMimeType();

    $media = $this->mediaRepository->findOneBy([
      'safeName' => $safeFilename,
      'size' => $fileSize,
      'type' => $fileType
    ]);

    if ($media) {
      return ["id" => $media->getId()];
    } else {
      $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
      $fileUrl = "http://localhost:8000/images/".$fileName;

      try {
          $file->move($this->getTargetDirectory(), $fileName);
      } catch (FileException $e) {
          // ... handle exception if something happens during file upload
      }

      return [
        "id" => null,
        "safeName" => $safeFilename,
        "name" => $fileName,
        "size" => $fileSize,
        "type" => $fileType,
        "url" => $fileUrl
      ];
    }
  }

  public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
