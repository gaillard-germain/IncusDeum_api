<?php

namespace App\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\{Response, Request};
use App\Repository\{CardRepository, CategoryRepository, FxRepository, MediaRepository};
use App\Entity\Card;
use App\Form\CardType;
use App\Service\ImageUploader;

class CardController extends ApiController
{
  /**
   * @Route("/card", name="app_card", methods={"GET"})
   */
  public function index(Request $request,
                        CardRepository $cardRepository): Response
  {
      $page = $request->get('page') - 1;
      $order = $request->get('order');
      $asc = $request->get('asc');
      if ($asc === 'true') {
        $dir = 'ASC';
      } else {
        $dir = 'DESC';
      }
      $cards = $cardRepository->findPage($page, $order, $dir);
      $pages = $cardRepository->countPage();

      return $this->normalizeData(
        ["cards" => $cards, "pages" => $pages],
        ['cards_list']
      );
  }

  /**
  * @Route("/card/{id}", name="app_card_detail", methods={"GET"})
  */
  public function details(Card $card)
  {
    return $this->normalizeData($card, ['card_detail']);
  }

  /**
  * @Route("/card", name="app_card_create", methods={"POST"})
  */
  public function create(Request $request, CardRepository $cardRepository,
                         CategoryRepository $categoryRepository,
                         FxRepository $fxRepository,
                         MediaRepository $mediaRepository)
  {
    $content = json_decode($request->getContent(), true);

    if($content["id"]) {
        $card = $cardRepository->find($content["id"]);
    } else {
        $card = new Card();
    };

    $card->setName($content["name"]);
    $card->setCategory($categoryRepository->find($content["category"]["id"]));
    $card->setValue($content["value"]);
    
    if ($content["frontImage"]["id"]) {
      $card->setFrontImage($mediaRepository->find($content["frontImage"]["id"]));
    } else {
      $card->setFrontImage($mediaRepository->findOneBy(["safeName" => "front"]));
    }

    if ($content["backImage"]["id"]) {
      $card->setBackImage($mediaRepository->find($content["backImage"]["id"]));
    } else {
      $card->setBackImage($mediaRepository->findOneBy(["safeName" => "back"]));
    }

    $card->setColor($content["color"]);
    $card->setDescription($content["description"]);
    foreach ($content["fx"] as $fx) {
      $card->addFx($fxRepository->find($fx["id"]));
    }
    try {
      $cardRepository->add($card);
    } catch (UniqueConstraintViolationException $e) {
      return new Response("This card's name already exists!", 409);
    }

    return $this->normalizeData($card, ['card_detail'], 201);
  }

  /**
  * @Route("/card/{id}", name="app_card_delete", methods={"DELETE"})
  */
  public function delete(Card $card, CardRepository $cardRepository,
                         MediaRepository $mediaRepository,
                         ImageUploader $imageUploader)
  {
    $media = $card->getFrontImage();
    $cardRepository->remove($card);

    $cardImageNbr = $cardRepository->countCardImage($media);
    if ($cardImageNbr < 1) {

      $filename = $media->getName();
      $filesystem = new Filesystem();
      $filesystem->remove($imageUploader->getTargetDirectory().'/'.$filename);

      $mediaRepository->remove($media);
    }

    return new Response("Removed ".$card->getName(), 200);
  }
}
