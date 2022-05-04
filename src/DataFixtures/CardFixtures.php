<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 12; $i++){
            $card = new Card();
            $card->setName('Carte n°'.$i);
            $card->setExample($i);
            $card->setPrice($i*100);
            $card->setImage($i . '.png');
            $card->setPurchaseDate(new \DateTimeImmutable());
            $card->setReleaseDate(new \DateTimeImmutable());
            $card->setIsOnSale(true);
            $card->setDescription('Voici une ravissante et rarissime carte provenant de la lointaine contrée de Azerty !');

            $manager->persist($card);
        }
        $manager->flush();
    }
}
