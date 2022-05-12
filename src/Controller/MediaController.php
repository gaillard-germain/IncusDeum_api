<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Media;
use App\Service\ImageUploader;

class MediaController extends AbstractController
{
  /**
   * @Route("/media", name="app_media", methods={"GET"})
   */
  public function index(): Response
  {
    return $this->json();
  }

  /**
   * @Route("/media", name="app_upload_media", methods={"POST"})
   */
  public function upload(EntityManagerInterface $manager, Request $request,
                         ImageUploader $imageUploader)
  {
    $imageFile = $request->files->get('file');

    if ($imageFile) {
      $imageFileName = $imageUploader->upload($imageFile);
      $media = new Media();
      $media->setName($imageFileName);
      $media->setSize(152540);
      $media->setType("image/jpeg");
      $manager->persist($media);
      $manager->flush();

      return $this->json(["id" => $media->getId()]);
    }

    return $this->json(["error" => "no file!"]);

  }
}
