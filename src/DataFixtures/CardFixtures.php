<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\{Card, Category, Fx, Media};

class CardFixtures extends Fixture
{
  const CARD_COUNT = 5;

  public function load(ObjectManager $manager): void
  {
    $front = new Media();
    $front->setName("front.jpg");
    $front->setSize(251500);
    $front->setType("image/jpeg");
    $front->setUrl("http://localhost:8000/images/front.jpg");
    $manager->persist($front);

    $back = new Media();
    $back->setName("back.jpg");
    $back->setSize(251500);
    $back->setType("image/jpeg");
    $back->setUrl("http://localhost:8000/images/back.jpg");
    $manager->persist($back);

    for ($i = 0; $i < self::CARD_COUNT; $i++) {
      $category = new Category();
      $category->setName("Category".$i);
      $manager->persist($category);

      $fx = new Fx();
      $fx->setName("Fx".$i);
      $fx->setValue("+".$i);
      $manager->persist($fx);

      $card = new Card();
      $card->setName("Card".$i);
      $card->setCategory($category);
      $card->setValue($i);
      $card->setFrontImage($front);
      $card->setBackImage($back);
      $card->setColor("#3f3429");
      $card->setDescription(
        "_'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'_"
      );
      $card->addFx($fx);
      $manager->persist($card);
    }

    $manager->flush();
  }
}
