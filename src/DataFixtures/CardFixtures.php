<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\{Card, Category, Fx};

class CardFixtures extends Fixture
{
  const CARD_COUNT = 10;

  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < self::CARD_COUNT; $i++) {
      $category = new Category();
      $category->setName("Test".$i);
      $manager->persist($category);

      $fx = new Fx();
      $fx->setName("Test".$i);
      $fx->setValue("+1/turn");
      $manager->persist($fx);

      $card = new Card();
      $card->setName("Test".$i);
      $card->setCategory($category);
      $card->setValue($i);
      $card->setDescription("Lorem ipsum dolor sit amet.");
      $card->addFx($fx);
      $manager->persist($card);
    }

    $manager->flush();
  }
}
