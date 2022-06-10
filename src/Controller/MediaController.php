<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Media;
use App\Form\MediaType;
use App\Service\ImageUploader;
use App\Repository\MediaRepository;

class MediaController extends ApiController
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
  public function create(MediaRepository $mediaRepository, Request $request,
                         ImageUploader $imageUploader)
  {
    $file = $request->files->get('file');

    if ($file) {
      $imageInfo = $imageUploader->upload($file);

      if ($imageInfo['media']) {
        return $this->normalizeData($imageInfo['media'], ['card_detail'], 200);
      } elseif ($imageInfo['data']) {

        $media = new Media();
        $form = $this->createForm(MediaType::class, $media);

        $form->submit($imageInfo['data']);

        if($form->isSubmitted() && $form->isValid()) {
          $mediaRepository->add($media);

          return $this->normalizeData($media, ['card_detail'], 201);
        }

        return $this->normalizeData(['errors' => $this->formErrors($form)], [],
                                    401);

      } else {
        return $this->json(["error" => "Bad file!"], 415);
      }
    }
    return $this->json(["error" => "No file!"], 404);
  }
}
