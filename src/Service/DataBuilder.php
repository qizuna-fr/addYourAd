<?php

namespace App\Service;

use App\Entity\Ad;
use DateTimeImmutable;

class DataBuilder
{
    /**
     * @param Log[] $logs
     */
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
        $day = (int) $date->format('d');
        for($i = 0; $i < 25; $i++)
        {
            $count = 0;
            foreach($logs as $log)
            {
                $logDate = new DateTimeImmutable($log["done_at"]);
                $logHours = (int) $logDate->format('H');
                $logDay = (int) $logDate->format('d');
                if($hours == $logHours && $day == $logDay)
                {
                    $count++;
                }
            }
            $data[] = $count;
            $hours++;
            if($hours == 24)
            {
                $hours = 0;
                $day++;
            }
        }
        return $data;
    }
}
