<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Trade;
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
        $actions = [["BTC/ETH","BTC/MCO",'BTC/CRO'],["CAC40","DAX30","DJ30"],["XAUUSD","OIL","SILVER"],["EUR/USD","USDCAD","CAD/JPY","EUR/JPY","AUDCAD"]];
        $positions = ["Achat","Vente"];

        // Création de mon utilisateur
        $alex = new User();
        $picture = 'https://randomuser.me/api/portraits/male/10';
        $hash = $this->encoder->encodePassword($alex, 'password');
        $alex->setFirstName("Alex")
                ->setLastName("Boisseau")
                ->setEmail("alex.boisseau@contact.com")
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
                ->setHash($hash)
                ->setPicture($picture);
        
        $manager->persist($alex);
        $users[] = $alex;

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

            for($y = 1; $y <= 5; $y++){
                $trade = new Trade();
                switch($marketType){
                    case "Cryptomonnaie":
                        $action = $faker->randomElement($actions[0]);
                    break;
                    case "Indices boursiers":
                        $action = $faker->randomElement($actions[1]);
                    break;
                    case "Forex":
                        $action = $faker->randomElement($actions[2]);
                    break;
                    case "Matières Premières":
                        $action = $faker->randomElement($actions[3]);
                    break;
                    default:
                        $action = "raté";
                    break;
                }
                $position = $faker->randomElement($positions);
                $enterPrice = round((rand(0,100)) / 70,4);
                $exitPrice = round((rand(0,100)) / 70, 4);
                $comment = $faker->sentence;
                $lots = (rand(0,100)) / 100;;
                $profit = $faker->numberBetween(-1000, 1000);

                $trade->setAction($action)
                ->setPosition($position)
                ->setBook($book)
                ->setEnterPrice($enterPrice)
                ->setExitPrice($exitPrice)
                ->setComment($comment)
                ->setLots($lots)
                ->setProfit($profit);

                $manager->persist($trade);
            }
        }

        $manager->flush();
    }
}
