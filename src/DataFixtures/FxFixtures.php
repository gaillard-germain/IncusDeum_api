<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Fx;

class FxFixtures extends Fixture
{
    const COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; $i++) {
          $fx = new Fx();
          $fx->setName("Fx".$i);
          $fx->setValue("+".$i);
          $this->addReference('fx'.$i, $fx);
          $manager->persist($fx);
      }

        $manager->flush();
    }
}
