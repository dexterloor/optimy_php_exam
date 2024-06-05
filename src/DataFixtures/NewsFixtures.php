<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\News;

class NewsFixtures implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Add 1st News entry in the database
        $news = new News();
        $news->setTitle('news 1');
        $news->setBody('this is the description of our fist news');
        $news->setCreatedAt('2016-11-30 14:18:23');

        $manager->persist($news);
        $manager->flush();

        // Add 2nd News entry in the database
        $news2 = new News();
        $news2->setTitle('news 2');
        $news2->setBody('this is the description of our second news');
        $news2->setCreatedAt('2016-11-30 14:24:23');

        $manager->persist($news2);
        $manager->flush();

        // Add 3rd News entry in the database
        $news3 = new News();
        $news3->setTitle('news 3');
        $news3->setBody('this is the description of our third news');
        $news3->setCreatedAt('2016-12-01 04:33:23');

        $manager->persist($news3);
        $manager->flush();
    }

    public function getOrder()
    {
        // We set the NewsFixture to be the 1st one to be executed
        return 1;
    }
}