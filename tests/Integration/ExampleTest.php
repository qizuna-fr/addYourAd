<?php

use App\Entity\Ad;
use Doctrine\ORM\EntityManager;
use App\Repository\AdRepository;
use App\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;

it('should have 15 item from the query', function(){
    
    $adRepository = $this->container->get(AdRepository::class);

    $ads = $adRepository->findAll();
    expect($ads)->toHaveCount(15);
});

it('should have 5 item from the query where the ad is valide today', function(){
    
    $adRepository = $this->container->get(AdRepository::class);

    $ads = $adRepository->findAdsValideToday();
    expect($ads)->toHaveCount(5);
});

it('should have the number of item indicate in the query where the ad is valide today', function(){
    
    $adRepository = $this->container->get(AdRepository::class);

    $ads = $adRepository->findANumberOfAdsValideToday(4);
    expect($ads)->toHaveCount(4);
});

it('it should have 16 item after added a new ad', function()
{
    $adRepository = $this->container->get(AdRepository::class);
    $manager = $this->container->get('doctrine.orm.default_entity_manager');
    
    $ads = $adRepository->findAll();

    $ad = new Ad;

    $ad->setWeight(3);
    $ad->setImageSize(7964);
    $ad->setStartedAt(new DateTimeImmutable('2023-07-28'));
    $ad->setEndedAt(new DateTimeImmutable('2023-11-02'));
    $ad->setUpdatedAt(new DateTimeImmutable('2023-09-13 09:14:24'));
    $ad->setImage('montain-65017d70cf558466455447.png');

    $manager->persist($ad);
    $manager->flush();

    $ads2 = $adRepository->findAll();

    expect(count($ads2) - count($ads))->toBe(1);
});

it('should have 15 logs from the query', function(){
    
    $logRepository = $this->container->get(LogRepository::class);

    $logs = $logRepository->findAllLogs();
    expect($logs)->toHaveCount(15);
});



it('should have 2 logs from the query', function(){
    
    $logRepository = $this->container->get(LogRepository::class);
    $adRepository = $this->container->get(AdRepository::class);

    $ads = $adRepository->findAdsValideToday();
    $id = $ads[0]->getId();
    $logs = $logRepository->findByIdLogs($id);

    expect($logs)->toHaveCount(2);
});