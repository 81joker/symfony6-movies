<?php

namespace App\DataFixtures;

use App\Entity\Movies;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MoviesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $movie = new Movies();
        $movie->setTitle('The Dark Knight');
        $movie->setReleaseYear(2008);
        $movie->setDescription('This is the description of the Dark Knight');
        $movie->setImagePath('https://cdn.pixabay.com/photo/2021/06/18/11/22/batman-6345897_960_720.jpg');

        //Add Data To Pivot Table
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));

        $manager->persist($movie);

        $movie2 = new Movies();
        $movie2->setTitle('Avengers: Endgame');
        $movie2->setReleaseYear(2019);
        $movie2->setDescription('This is the description of Avengers: Endgame');
        $movie2->setImagePath('https://cdn.pixabay.com/photo/2020/07/02/19/36/marvel-5364165_960_720.jpg');
        //Add Data To Pivot Table
        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));

        $manager->persist($movie2);

        $movie3 = new Movies();
        $movie3->setTitle('Friends  sitcom');
        $movie3->setReleaseYear(1994);
        $movie3->setDescription('Friends is an American sitcom that ran from 1994 to 2004.');
        $movie3->setImagePath('https://www.tz.de/bilder/2021/05/28/90734953/26177086-die-friends-stars-lisa-kudrow-matthew-perry-jennifer-aniston-david-schwimmer-courteney-cox-und-matt-leblanc-stehen-nebeneinander-2b9HPoRIMGe9.jpg');
        $manager->persist($movie3);

        $manager->flush();
    }
}
