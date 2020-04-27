<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setFirstName("Georges")
            ->setName("Sand")
            ->setDateOfBirth(new \DateTime("1804-07-01"));
        $manager->persist($author);
        $this->addReference("author_sand", $author);

        $author = new Author();
        $author->setFirstName("Victor")
            ->setName("Hugo")
            ->setDateOfBirth(new \DateTime("1802-03-27"));
        $manager->persist($author);
        $this->addReference("author_hugo", $author);

        $author = new Author();
        $author->setFirstName("Paul")
            ->setName("Auster")
            ->setDateOfBirth(new \DateTime("1947-03-03"));
        $manager->persist($author);
        $this->addReference("author_auster", $author);

        $manager->flush();
    }
}
