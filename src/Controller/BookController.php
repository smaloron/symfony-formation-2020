<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index()
    {
        //Liste de tous les livres
        $repository = $this->getDoctrine()->getRepository("App:Book");
        $books = $repository->findAll();

        return $this->render('book/index.html.twig', [
            'bookList' => $books,
        ]);
    }

    /**
     * @Route("/new", name="book-new")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showForm(){
        //Création d'une instance de Book
        $book = new Book();

        //Création du formulaire
        $form = $this->createForm(BookType::class, $book);

        return $this->render("book/form.html.twig", [
            //Envoie du formulaire au modèle Twig
            'bookForm' => $form->createView()
        ]);
    }
}