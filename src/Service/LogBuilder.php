<?php

namespace App\Service;

use App\Service\DateBuilder;
use App\Repository\AdRepository;
use App\Repository\LogRepository;

class LogBuilder
{
    public function createLogsAll(DateBuilder $dateBuilder, LogRepository $logRepository, AdRepository $adRepository, int $id)
    {
        $date = $dateBuilder->dateAd($adRepository->find($id));
        $logs = $logRepository->findByIdDateLogs($date[0]->format('Y-m-d H:i:s'), $date[1]->format('Y-m-d H:i:s'), $id);

        return $logs;
    }
}