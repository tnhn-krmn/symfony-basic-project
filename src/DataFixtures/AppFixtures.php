<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $ticket1 = new Ticket();
        $category = new Category();
    
        $ticket1->setName('Ticket 1');
        $ticket1->setPriority(rand(0,3));
        $ticket1->setStatus(rand(4,5));
        // $ticket1->setCategory($category);
        $manager->persist($ticket1);
        $manager->flush();
    }
}
