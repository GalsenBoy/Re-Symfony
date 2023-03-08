<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
         for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(4));
            $article->setContent($faker->paragraph(10));
            $article->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
