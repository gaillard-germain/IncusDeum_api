<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    const COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT; $i++) {
          $category = new Category();
          $category->setName("Category".$i);
          $this->addReference('category'.$i, $category);
          $manager->persist($category);
      }
        $manager->flush();
    }
}
