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
    for ($i = 0; $i < self::CARD_COUNT; $i++) {
      $category = new Category();
      $category->setName("Category".$i);
      $manager->persist($category);

      $fx = new Fx();
      $fx->setName("Fx".$i);
      $fx->setValue("+".$i);
      $manager->persist($fx);

      $media = new Media();
      $media->setName("image".$i.".jpg");
      $media->setSize($i*100);
      $media->setType("image/jpeg");
      $manager->persist($media);

      $card = new Card();
      $card->setName("Card".$i);
      $card->setCategory($category);
      $card->setValue($i);
      $card->setFrontImage($media);
      $card->setBackImage($media);
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
