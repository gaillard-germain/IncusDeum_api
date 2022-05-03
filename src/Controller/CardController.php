<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CardRepository;
use App\Entity\{Card, Category, Fx};

class CardController extends AbstractController
{
  /**
   * @Route("/card", name="app_card")
   */
  public function index(CardRepository $cardRepository): Response
  {
    $cards = $cardRepository->findAll();
    $result = [];
    foreach ($cards as $card) {
      $effects = [];
      foreach($card->getFx() as $fx) {
        $effects[$fx->getName()] = $fx->getValue();
      };
      $result[] = [
        "id" => $card->getId(),
        "name" => $card->getName(),
        "value" => $card->getValue(),
        "category" => $card->getCategory()->getName(),
        "description" => $card->getDescription(),
        "fx" => $effects
      ];
    }
    return $this->json($result);
  }
}
