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
        // TODO: faire en sorte d'envoyer 0 quand si il n'y a pas de log au heure envoyer (faire un for et non un foreach)
        $data = [];
        $i = 0;
        $hours = (int) $date->format('H');
        $day = (int) $date->format('d');
        // foreach($logs as $log)
        // {
        //     $logHour = new DateTimeImmutable($log["done_at"]);
        //     $logHours = (int) $logHour->format('H');
        //     // dd((int) $logHour->format('H'));
        //     // dd($logHours);
        //     if($hours == $logHours)
        //     {
        //         $i++;
        //     }
        //     else
        //     {
        //         $data[] = $i;
        //         $i = 0;
        //         $hours++;
        //         if($hours == 24)
        //         {
        //             $hours = 0;
        //         }
        //         if($hours == $logHours)
        //         {
        //             $i++;
        //         }
        //     }
        // }
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
    public function oneAdLogForCSV(array $logs)
    {
        $content = [['type','doneAt']];
        foreach($logs as $log)
        {
            $content[] = [$log['type'],$log['done_at']];
        }
        return $content;
    }
}
