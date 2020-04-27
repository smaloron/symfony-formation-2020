<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BookFixtures extends Fixture
{

    private  array $authorList = [
        "sand","hugo","auster"
    ];

    private array $genreList = [
        "Poésie", "Roman", "Policier", "Essai"
    ];

    private array $publisherList = [
        "Grasset", "Hachette", "Le Seuil", "PUF"
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
            ->setPublisher($this->chooseOne($this->publisherList))
            ->setText($this->faker->paragraph(8));


        return $book;
    }

    private function chooseOneAuthor(){
        $key = "author_". $this->chooseOne($this->authorList);
        return $this->getReference($key);
    }

    private function chooseOne($collection){
       return $collection[array_rand($collection)] ;
    }
}
