<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Comment;
use App\Entity\News;

class CommentFixtures implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Get News Objects to be related to comments
        $news1 = $manager->getRepository(News::class)->find(1);
        $news2 = $manager->getRepository(News::class)->find(2);
        $news3 = $manager->getRepository(News::class)->find(3);

        // Add 1st Comment entry
        $comment1 = new Comment();
        $comment1->setNews($news1);
        $comment1->setBody('i like this news');
        $comment1->setCreatedAt('2016-11-30 14:21:23');
        $manager->persist($comment1);
        $manager->flush();

        // Add 2nd Comment entry
        $comment2 = new Comment();
        $comment2->setNews($news1);
        $comment2->setBody('i have no opinion about that');
        $comment2->setCreatedAt('2016-11-30 14:24:08');
        $manager->persist($comment2);
        $manager->flush();

        // Add 3rd Comment entry
        $comment3 = new Comment();
        $comment3->setNews($news1);
        $comment3->setBody('are you kidding me ?');
        $comment3->setCreatedAt('2016-11-30 14:28:06');
        $manager->persist($comment3);
        $manager->flush();

        // Add 4th Comment entry
        $comment4 = new Comment();
        $comment4->setNews($news2);
        $comment4->setBody('this is so true');
        $comment4->setCreatedAt('2016-11-30 17:21:23');
        $manager->persist($comment4);
        $manager->flush();

        // Add 5th Comment entry
        $comment5 = new Comment();
        $comment5->setNews($news2);
        $comment5->setBody('trolololo');
        $comment5->setCreatedAt('2016-11-30 17:39:25');
        $manager->persist($comment5);
        $manager->flush();

        // Add 6th Comment entry
        $comment6 = new Comment();
        $comment6->setNews($news3);
        $comment6->setBody('luke i am your father');
        $comment6->setCreatedAt('2016-11-30 14:34:06');
        $manager->persist($comment6);
        $manager->flush();
    }

    public function getOrder()
    {
        // We set the CommentsFixture to be the 2nd one to be executed
        return 2;
    }

}