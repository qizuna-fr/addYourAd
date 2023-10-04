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

    /**
     * @param Log[] $logs
     */
    public function dataPerHours(array $logs, DateTimeImmutable $date): array
    {
        $data = [];
        $i = 0;
        $hours = (int) $date->format('H');
        foreach($logs as $log)
        {
            $logHour = new DateTimeImmutable($log["done_at"]);
            // dd((int) $logHour->format('H'));
            $logHours = (int) $logHour->format('H');
            // dd($logHours);
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
