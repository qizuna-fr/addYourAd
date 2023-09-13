<?php

use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;

it('should have 10 item from the query where the ad is done', function(){
    
    $adRepository = $this->container->get(AdRepository::class);

    $finished = $adRepository->findAll();
    expect($finished)->toHaveCount(10);
});
