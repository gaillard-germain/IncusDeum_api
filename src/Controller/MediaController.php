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
   * @Route("/media", name="app_create_media", methods={"POST"})
   */
  public function create(EntityManagerInterface $manager, Request $request,
                         ImageUploader $imageUploader)
  {
    $file = $request->files->get('file');

    if ($file) {
      $imageFile = $imageUploader->upload($file);
      $media = new Media();
      $media->setName($imageFile["name"]);
      $media->setSize($imageFile["size"]);
      $media->setType($imageFile["type"]);
      $manager->persist($media);
      $manager->flush();

      return $this->json(["id" => $media->getId()]);
    }

    return $this->json(["error" => "no file!"]);

  }
}
