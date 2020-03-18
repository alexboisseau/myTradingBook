<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager){
        $faker = Factory::create('FR-fr');

        // Gestion des utilisateurs
        $users = [];
        $genres = ['male','female'];
        $market_type = ['Cryptomonnaie','Indices boursiers','Matières Premières','Forex'];

        for($i = 1; $i <= 10; $i++){
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99).'.jpg';

            $picture .= ($genre == 'male' ? 'men/':'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
            
        }

        for($i = 1; $i <=30; $i++){
            $book = new Book();

            $title = $faker->sentence();
            $marketType = $market_type[mt_rand(0, count($market_type) - 1)];
            $bookDate = $faker->dateTimeBetween('-6 months');

            $user = $users[mt_rand(0, count($users) - 1)];


            $book->setTitle($title)
               ->setMarketType($marketType)
               ->setAuthor($user)
               ->setBookDate($bookDate);
            
            $manager->persist($book);
        }

        $manager->flush();
    }
}
