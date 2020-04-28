<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
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
        $data = $repository->findAllPaginated();

        $books = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('book/index.html.twig', [
            'bookList' => $books
        ]);
    }

    /**
     * @Route("/new", name="book-new")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showForm(Request $request){
        //Création d'une instance de Book
        $book = new Book();

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
}
