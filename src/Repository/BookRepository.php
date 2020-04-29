<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAllPaginated(){
        return $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery();
    }

    public function findAllBooks($genre){
        $qb = $this ->createQueryBuilder('b')
                    ->select('b')
                    ->where("b.genre=?1")
                    ->orderBy('b.title', 'DESC')
                    ->setParameter(1, $genre)
                    ->setMaxResults(5);

        return $qb->getQuery();
    }

    public function findOldestBooksByGenre($genre, $numberOfBooks){
        $qb = $this ->createQueryBuilder('b')
            ->select('b, a')
            ->where("b.genre=?1")
            ->andWhere("a.name='Hugo'")
            ->innerJoin('b.author', 'a')
            ->orderBy('b.publishedAt', 'ASC')
            ->setParameter(1, $genre)
            ->setMaxResults($numberOfBooks);

        return $qb->getQuery();
    }

    public function getBookPricesByGenre(){
        $qb = $this->createQueryBuilder('b')
            ->select('b.genre, SUM(b.price) as total')
            ->groupBy('b.genre');

        return $qb->getQuery();
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
