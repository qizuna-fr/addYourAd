<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Log;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;

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
            $ad->setImage('montain-651287f630f3a193737599.png');
            $ad->setImageFile(new File('public/img/uploads/montain-651287f630f3a193737599.png'));
            // dd($ad);1

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
            $ad->setImage('fisherman-6512884e3bae1461386075.png');
            $ad->setImageFile(new File('public/img/uploads/fisherman-6512884e3bae1461386075.png'));

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
            $ad->setImage('coffee-651196886336d135247029.png');
            $ad->setImageFile(new File('public/img/uploads/coffee-651196886336d135247029.png'));

            $manager->persist($ad);
            $manager->flush();
        }
        for ($count = 0; $count < 5; $count++) {
            $log = new Log();

            $log->setSeen();

            $manager->persist($log);
            $manager->flush();
        }
        for ($count = 0; $count < 5; $count++) {
            $log = new Log();

            $log->setClick();

            $manager->persist($log);
            $manager->flush();
        }
    }
}
