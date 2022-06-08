<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Media;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $front = new Media();
        $front->setSafeName("front");
        $front->setName("front.jpg");
        $front->setSize(251500);
        $front->setType("image/jpeg");
        $front->setUrl("http://localhost:8000/images/front.jpg");
        $this->addReference('front', $front);
        $manager->persist($front);

        $back = new Media();
        $back->setSafeName("back");
        $back->setName("back.jpg");
        $back->setSize(251500);
        $back->setType("image/jpeg");
        $back->setUrl("http://localhost:8000/images/back.jpg");
        $this->addReference('back', $back);
        $manager->persist($back);

        $manager->flush();
    }
}
