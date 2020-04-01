<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Stats {
    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    public function getUsersCount(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getBooksCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Book b')->getSingleScalarResult();
    }

    public function getTradesCount(){
        return $this->manager->createQuery('SELECT COUNT(t) FROM App\Entity\Trade t')->getSingleScalarResult();
    }

    public function getMessagesCount(){
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Message m')->getSingleScalarResult();
    }

    public function getStats(){
        $users = $this->getUsersCount();
        $books = $this->getBooksCount();
        $trades = $this->getTradesCount();
        $messages = $this->getMessagesCount();

        return compact('users','books','trades','messages');
    }
}