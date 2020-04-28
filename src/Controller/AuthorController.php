<?php

namespace App\Controller;

use App\Entity\Author;
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
    public function index()
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    /**
     * @Route("/{id}", name="author-details", requirements={"id":"\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOne(Author $author){

        return $this->render('author/show-one.html.twig', ['author' => $author]);
    }
}
