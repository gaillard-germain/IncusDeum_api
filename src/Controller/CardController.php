<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{Response, Request};
use App\Repository\{CardRepository, CategoryRepository};
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
  public function details(CardRepository $cardRepository, $id)
  {
    $card = $cardRepository->find($id);
    return $this->normalizeData($card, ['card_detail']);
  }

  /**
  * @Route("/card", name="app_card_create", methods={"POST"})
  */
  public function create(Request $request, EntityManagerInterface $manager,
                         CategoryRepository $categoryRepository)
  {
    $content = json_decode($request->getContent(), true);

    $category = $categoryRepository->find($content["category"]["id"]);

    $fx = new Fx();
    $fx->setName($content["fx"]);
    $fx->setValue("+1");
    $manager->persist($fx);

    $card = new Card();
    $card->setName($content["name"]);
    $card->setCategory($category);
    $card->setValue($content["value"]);
    // $card->setFrontImage($content["frontImage"]);
    // $card->setBackImage($content["backImage"]);
    // $card->setColor($content["color"]);
    $card->setDescription($content["description"]);
    $card->addFx($fx);
    $manager->persist($card);

    $manager->flush();

    // $form = $this->createForm(CardType::class, $card);
    //
    // $form->submit(json_decode($request->getContent(), true));
    //
    // $form->handleRequest($request);
    //
    // if($form->isSubmitted() && $form->isValid()) {
    //   $manager->persist($card);
    //   $manager->flush();
    //   return $this->normalizeData($card, ['card_detail'], 201);
    // }

    // return $this->normalizeData(['errors' => $this->formErrors($form)], [], 401);
    return $this->json($content);
  }
}
