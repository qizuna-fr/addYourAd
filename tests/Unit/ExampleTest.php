<?php

use App\Entity\Ad;

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

})->throws(InvalidArgumentException::class);
