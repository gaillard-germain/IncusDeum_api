<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use App\Controller\ApiController;
use App\Repository\{CardRepository, CategoryRepository, FxRepository};
use App\Entity\{ Card, Category, Fx };
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CardType;

class CardController extends ApiController
{
  /**
   * @Route("/card", name="app_card", methods={"GET"})
   */
  public function index(CardRepository $cardRepository): Response
  {
    $cards = $cardRepository->findAll();
    return $this->normalizeData($cards, ['cards_list']);
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
  public function create(Request $request, EntityManagerInterface $manager,
                         CategoryRepository $categoryRepository,
                         FxRepository $fxRepository)
  {
    $content = json_decode($request->getContent(), true);

    $card = new Card();
    $card->setName($content["name"]);
    $card->setCategory($categoryRepository->find($content["category"]["id"]));
    $card->setValue($content["value"]);
    // $card->setFrontImage($content["frontImage"]);
    // $card->setBackImage($content["backImage"]);
    // $card->setColor($content["color"]);
    $card->setDescription($content["description"]);
    foreach ($content["fx"] as $fx) {
      $card->addFx($fxRepository->find($fx["id"]));
    }

    $manager->persist($card);
    $manager->flush();

    return $this->json($content);
  }
}
