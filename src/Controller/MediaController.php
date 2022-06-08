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

      if ($imageFile["id"]) {
        return $this->json(["id" => $imageFile["id"]], 200);
      } else {
        $media = new Media();
        $media->setSafeName($imageFile["safeName"]);
        $media->setName($imageFile["name"]);
        $media->setSize($imageFile["size"]);
        $media->setType($imageFile["type"]);
        $media->setUrl($imageFile["url"]);
        $manager->persist($media);
        $manager->flush();

        return $this->json(["id" => $media->getId()], 200);
      }
    }

    return $this->json(["error" => "no file!"], 404);
  }
}
