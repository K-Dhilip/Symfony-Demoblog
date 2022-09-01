<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++)
        {
        $article = new Article(); // on instancie la class Article() qui se trouve dans le dossier App\Entity
        // Nous pouvons maintenant faire appel au setteur pour créer des articles
        $article->setTitle("Titre de l'article n°$i")
        ->setContent("<p>Contenu de l'article n°$i</p>")
        ->setImage("http://placehold.it/250x150")
        ->setCreatedAt(new \DateTime()); // on instancie la classe DateTime() pour formater l'heure
        $manager->persist($article); // permet de faire persister l'article dans le temps
        }
        
        $manager->flush(); // la méthode flush() balance réellement la requête SQL qui mettra en place les différentes manipulations que nous avons fait ici
        }
}
