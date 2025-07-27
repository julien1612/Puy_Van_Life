<?php

namespace App\DataFixtures;

use App\Factory\CommentFactory;
use App\Factory\EventFactory;
use App\Factory\LocationFactory;
use App\Factory\PictureFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
UserFactory::createMany(200);
LocationFactory::createMany(200);
CommentFactory::createMany(200);
PictureFactory::createMany(300);
EventFactory::createMany(200);
        $manager->flush();
    }
}
