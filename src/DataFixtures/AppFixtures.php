<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($count = 0; $count < 5; $count++) {
            $ad = new Ad();

            $ad->setWeight(3);
            $ad->setImageSize(7964);
            $ad->setStartedAt(new DateTimeImmutable('2023-07-30'));
            $ad->setEndedAt(new DateTimeImmutable('2023-08-30'));
            $ad->setUpdatedAt(new DateTimeImmutable('2023-09-13 09:14:24'));
            $ad->setImage('montain-65017d70cf558466455447.png');

            $manager->persist($ad);
            $manager->flush();
        }
        for ($count = 0; $count < 5; $count++) {
            $ad = new Ad();

            $ad->setWeight(3);
            $ad->setImageSize(7964);
            $ad->setStartedAt(new DateTimeImmutable('2023-08-31'));
            $ad->setEndedAt(new DateTimeImmutable('2023-10-31'));
            $ad->setUpdatedAt(new DateTimeImmutable('2023-09-13 09:14:24'));
            $ad->setImage('montain-65017d70cf558466455447.png');

            $manager->persist($ad);
            $manager->flush();
        }
        for ($count = 0; $count < 5; $count++) {
            $ad = new Ad();

            $ad->setWeight(3);
            $ad->setImageSize(7964);
            $ad->setStartedAt(new DateTimeImmutable('2023-10-30'));
            $ad->setEndedAt(new DateTimeImmutable('2023-11-30'));
            $ad->setUpdatedAt(new DateTimeImmutable('2023-09-13 09:14:24'));
            $ad->setImage('montain-65017d70cf558466455447.png');

            $manager->persist($ad);
            $manager->flush();
        }
    }
}
