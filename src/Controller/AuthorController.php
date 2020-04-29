<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorController
 * @package App\Controller
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="author-list")
     */
    public function index(AuthorRepository $repository)
    {
        return $this->render('author/index.html.twig', [
            'authorList' => $repository->getAuthorListWithBooks()->getResult()
        ]);
    }

    /**
     * @Route("/{id}", name="author-details", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOne(Author $author, AuthorRepository $repository){

        return $this->render('author/show-one.html.twig', [
            'author' => $author,
            'publisherList' => $repository->getPublishersByAuthor($author)->getResult()
        ]);
    }
}
