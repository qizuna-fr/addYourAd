<?php

namespace App\Service;

use App\Entity\Ad;
use DateTimeImmutable;

class DataBuilder
{
    public function separator(array $logs): array
    {
        $data = ['seen' => [], 'click' => []];
        foreach($logs as $log)
        {
            if($log->getType() == 'seen')
            {
                $data['seen'][] = $log;
            }
            else
            {
                $data['click'][] = $log;
            }
        }
        return $data;
    }

    public function dataPerHours(array $logs, DateTimeImmutable $date): array
    {
        $data = [];
        $i = 0;
        $hours = (int) $date->format('H');
        foreach($logs as $log)
        {
            $logHours = (int) $log->getDoneAt()->format('H');
            if($hours == $logHours)
            {
                $i++;
            }
            else
            {
                $data[] = $i;
                $i = 0;
                $hours = $logHours;
            }
        }
        return $data;
    }
}
