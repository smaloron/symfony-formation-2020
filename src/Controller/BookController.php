<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController
 * @package App\Controller
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("-list", name="book-list")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        //Liste de tous les livres
        $repository = $this->getDoctrine()->getRepository("App:Book");
        $query = $repository->findAllPaginated();

        $books = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $booksByYear = $repository->getBooksNumberByYear();

        return $this->render('book/index.html.twig', [
            'bookList' => $books,
            'bookByYear' => $booksByYear
        ]);
    }

    /**
     * @Route("/new", name="book-new")
     * @Route("/update/{id}", name="book-update", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showForm(Request $request, Book $book = null){
        //Création d'une instance de Book
        if($book == null){
            $book = new Book();
        }

        //Création du formulaire
        $form = $this->createForm(BookType::class, $book);

        //traitement du formulaire à partir des données de la requête
        $form->handleRequest($request);

        //Persistence de l'entité avec Doctrine
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            //Redirection vers la liste des livres
            return $this->redirectToRoute('book-list');
        }

        return $this->render("book/form.html.twig", [
            //Envoie du formulaire au modèle Twig
            'bookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/test", name="book-test")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testQuery(BookRepository $repository){

        $allBooks = $repository->findAllBooks("Essai");
        $oldestBooks = $repository->findOldestBooksByGenre("Essai", 5);

        $bookPricesByGenre = $repository->getBookPricesByGenre();

        dump($oldestBooks->getSQL());
        dump($oldestBooks->getDQL());


        return $this->render("book/test-query.html.twig", [
            'allBooks' => $allBooks->getResult(),
            'oldestBooks' => $oldestBooks->getResult(),
            'booksByGenre' => $bookPricesByGenre->getResult()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="book-delete", requirements={"id":"\d+"})
     * @param Book $book
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Book $book, EntityManagerInterface $em){
        $em->remove($book);
        $em->flush();
        $this->addFlash("info", "Votre livre est supprimé");
        return $this->redirectToRoute('book-list');
    }
}
