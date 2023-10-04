<?php

namespace App\Service;

use App\Entity\Ad;
use DateTimeImmutable;

class DataBuilder
{
    public function filterLogType(array $logs, string $type)
    {
        return array_filter($logs, fn($log) => $log['type'] == $type);
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
