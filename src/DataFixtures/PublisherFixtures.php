<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PublisherFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $publisherList = ["Hachette", "PUF", "Seuil", "Grasset"];

        foreach ($publisherList as $publisherName){
            $publisher = new Publisher();
            $publisher->setName($publisherName);
            $manager->persist($publisher);
            $this->addReference("publisher_".strtolower($publisherName), $publisher);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
