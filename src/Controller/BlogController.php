<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\component\Form\Extension\Core\Type\TextType;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur le blog Symfony',
            'age' => 25
        ]);
    }
    /**
     * @Route("/blog/index", name="blog_index")
     */
    public function index(ArticleRepository $repo): Response
    {

        $article = $repo->findBy(array(), array('id' => 'ASC'));

        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article(); // nous déclarons un article qui est vide mais pret à être rempli
        // $form est un objet complexe, nous allons demander à symfony de nous stocker le formulaire dans une variable simple à utilier.
        $form = $this->createFormBuilder($article) // cela va créer un objet qui est lié à notre article
            ->add('title') // add() fonction permettant de créer des champs dans un formulaire
            ->add('content', textType::class)
            ->add('image')
            ->getForm(); // permet d'afficher le rendu final
        return $this->render('blog/create.html.twig', [
            // createView() va retourner un petit objet qui représente l'affichage du formulaire, on le récupère sur la page create.html.twig
            'formArticle' => $form->createView()
        ]);
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article

        ]);
    }
}
