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

    /**
     * @param Log[] $logs
     */
    public function allDataPerHours(array $logs): array
    {
        $data = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 0,
            18 => 0,
            19 => 0,
            20 => 0,
            21 => 0,
            22 => 0,
            23 => 0
        ];
        foreach($logs as $log)
        {
            $logDate = new DateTimeImmutable($log["done_at"]);
            $logHours = (int) $logDate->format('H');
            $data[$logHours]++ ;
        }
        return $data;
    }
}
