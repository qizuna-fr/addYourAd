<?php

namespace App\Service;

use App\Entity\Ad;

class DateBuilder
{
    public function dateAd(Ad $ad)
    {
        $date[] = $ad->getStartedAt();
        $date[] = $ad->getEndedAt();

        return $date;
    }
}