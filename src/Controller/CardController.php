<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use App\Repository\CardRepository;
use App\Entity\Card;
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
  public function details(CardRepository $cardRepository, $id): Response
  {
    $card = $cardRepository->find($id);
    return $this->normalizeData($card, ['card_detail']);
  }

  /**
  * @Route("/card", name="app_card_create", methods={"POST"})
  */
  public function create(Request $request, EntityManagerInterface $manager): Response
  {
    $card = new Card();

    $form = $this->createForm(CardType::class, $card);

    $form->submit(json_decode($request->getContent(), true));

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      $manager->persist($card);
      $manager->flush();
      return $this->normalizeData($card, ['card_detail'], 201);
    }

    return $this->normalizeData(['errors' => $this->formErrors($form)], [], 401);
  }
}
