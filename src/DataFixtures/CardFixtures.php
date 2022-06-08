<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Card;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
  const COUNT = 5;

  public function load(ObjectManager $manager): void
  {
    for ($i = 0; $i < self::COUNT; $i++) {
      $card = new Card();
      $card->setName("Card".$i);
      $card->setCategory($this->getReference('category'.random_int(0, CategoryFixtures::COUNT - 1)));
      $card->setValue(random_int(1, 20));
      $card->setFrontImage($this->getReference('front'));
      $card->setBackImage($this->getReference('back'));
      $card->setColor("#3f3429");
      $card->setDescription(
        "_'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'_"
      );
      $card->addFx($this->getReference('fx'.random_int(0, FxFixtures::COUNT - 1)));
      $manager->persist($card);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
      return [
          CategoryFixtures::class,
          FxFixtures::class,
          MediaFixtures::class
      ];
  }
}
