<?php

namespace App\Service;

use App\Entity\Ad;
use DateTimeImmutable;

class LabelBuilder
{
    public function hoursLabelFromYesterday(DateTimeImmutable $date, DateTimeImmutable $today): array
    {
        $hours = (int) $date->format('H');
        $label = [$hours];

        for($i = 0; $i < 24; $i++)
        {
            $hours++;
            if($hours == 24)
            {
                $hours = 0;
            }
            if($i == 23)
            {
                $hours .= ' ('.$today->format('H:i').')';
            }
            $label[] = $hours;
        }

        return $label;
    }
}
