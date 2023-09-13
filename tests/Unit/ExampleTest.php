<?php

use App\Entity\Ad;
use App\Entity\AdCollection;

it('should register a new ad', function () {

    $ad = new Ad();

    $ad->setStartedAt(new DateTimeImmutable('2023-11-03'));
    $ad->setEndedAt(new DateTimeImmutable('2023-12-16'));
    // $ad->setWeight(4);
    // $ad->setViews(60);
    // $ad->setImage('1');

    expect($ad->getEndedAt())->toBeGreaterThan($ad->getStartedAt());

});

it('should not register an ad with a ended date that is before the started date' , function(){

    $ad = new Ad();

    $ad->setStartedAt(new DateTimeImmutable('2023-12-03'));
    $ad->setEndedAt(new DateTimeImmutable('2023-11-16'));

    expect($ad->getEndedAt())->toBeNull();
});

it('should register an add into a collection of diffusable ads', function () {
    //arrange
    $collection = new AdCollection();
    //act
    $collection->addAd(new Ad());
    //assert
    expect($collection->getAds())->toHaveCount(1)
        ->and($collection->getAds()[0])->toBeInstanceOf(Ad::class);
});

it('should register multiple ads into a collection of diffusable ads', function () {
    //arrange
    $collection = new AdCollection();

    $collection->addAd(new Ad());
    $collection->addAd(new Ad());

    expect($collection->getAds())->toHaveCount(2);
});


it('should increment number of views each time a ad is displayed', function () {
    //arrange
    $collection = new AdCollection();
    
    $collection->addAd(new Ad());
    $collection->addAd(new Ad());

    //act
    $collection->displayOneRandomly();
    $collection->displayOneRandomly();

    $ads = $collection->getAds();
    expect($ads[0]->getViewsCount())->toBe(1)
        ->and($ads[1]->getViewsCount())->toBe(1);
});

it('should display ads depending weight of each add in collection', function () {
    //arrange
    $collection = new AdCollection();

    $ad1 = new Ad();
    $ad1->setViews(1);
    $ad2 = new Ad();
    $ad2->setViews(2);
    $ad3 = new Ad();
    $ad3->setViews(3);

    $collection->addAd($ad1);
    $collection->addAd($ad2);
    $collection->addAd($ad3);

    //act
    expect($collection->getSequence())->toHaveCount(6);
});

it('should display randomly each ad of collection n times depending his weight', function () {
    $collection = new AdCollection();

    $ad1 = new Ad();
    $ad1->setViews(1);
    $ad2 = new Ad();
    $ad2->setViews(2);
    $ad3 = new Ad();
    $ad3->setViews(3);

    $collection->addAd($ad1);
    $collection->addAd($ad2);
    $collection->addAd($ad3);

    //si j'apelle 6 fois consecutives la methode displayOneRandomly
    // je dois obtenir que le nombre d'affichage de chaque pub corresponde a sont poids

    for ($i = 0; $i < 6; $i++) {
        $collection->displayOneRandomly();
    }

    expect($collection->getAds()[0]->getViewsCount())->toBe(1);
    expect($collection->getAds()[1]->getViewsCount())->toBe(2);
    expect($collection->getAds()[2]->getViewsCount())->toBe(3);
});

it('should count views over multiple sequences', function () {

    // si on affiche une pub , on compte le nombre d'affichages dans la collection
    // mais il faut aussi compter le nombre d'affichages total

    $collection = new AdCollection();
    $collection->addAd(new Ad(1));

    for ($i = 0; $i < 6; $i++) {
        $collection->displayOneRandomly();
    }

    expect($collection->getAds()[0]->getTotalViews())->toBe(6);

});

// should reset sequences count after complete sequence