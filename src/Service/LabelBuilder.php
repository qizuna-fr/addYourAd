<?php

namespace App\Service;

use App\Entity\Ad;
use DateTimeImmutable;

class LabelBuilder
{
    public function hoursLabelFromYesterday(DateTimeImmutable $date): array
    {
        $hours = (int) $date->format('H');
        $label = [$hours];

        for($i = 0; $i < 25; $i++)
        {
            $hours++;
            if($hours == 24)
            {
                $hours = 0;
            }
            $label[] = $hours;
        }

        return $label;
    }
}
