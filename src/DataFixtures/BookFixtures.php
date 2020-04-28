<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BookFixtures extends Fixture implements OrderedFixtureInterface
{

    private  array $authorList = [
        "sand","hugo","auster"
    ];

    private array $genreList = [
        "Poésie", "Roman", "Policier", "Essai"
    ];

    private array $publisherList = [
        "grasset", "hachette", "seuil", "puf"
    ];

    private Generator $faker;

    /**
     * BookFixtures constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }


    public function load(ObjectManager $manager)
    {

        for($i=1; $i <= 100; $i++){
            $book = $this->createBook();
            $manager->persist($book);
        }

        $manager->flush();
    }

    private function createBook(){
        $book = new Book();
        $book->setAuthor($this->chooseOneAuthor())
            ->setTitle($this->faker->catchPhrase())
            ->setPublishedAt($this->faker->dateTimeThisCentury())
            ->setPrice($this->faker->numberBetween(500, 90000)/100)
            ->setGenre($this->chooseOne($this->genreList))
            ->setPublisher($this->chooseOnePublisher())
            ->setText($this->faker->paragraph(8));


        return $book;
    }

    private function chooseOnePublisher(): Publisher{
        $key = "publisher_". $this->chooseOne($this->publisherList);
        return $this->getReference($key);
    }

    private function chooseOneAuthor(): Author{
        $key = "author_". $this->chooseOne($this->authorList);
        return $this->getReference($key);
    }

    private function chooseOne($collection){
       return $collection[array_rand($collection)] ;
    }

    public function getOrder()
    {
        return 10;
    }
}
