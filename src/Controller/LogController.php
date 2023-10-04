<?php

namespace App\Controller;

use DateInterval;
use DateTimeImmutable;
use App\Service\DataBuilder;
use App\Service\LabelBuilder;
use App\Repository\LogRepository;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogController extends AbstractController
{
    #[Route('/log/today/{id}', name: 'app_log')]
    public function index(Request $request, ChartBuilderInterface $chartBuilder, LabelBuilder $labelBuilder, DataBuilder $dataBuilder, LogRepository $logRepository): Response
    {
        $today = new DateTimeImmutable();
        $newToday = $today->setTime((int) $today->format('H'), 0, 0);
        $yesterday = $newToday->add(new DateInterval('P1D'));
        $label = $labelBuilder->hoursLabelFromYesterday($yesterday);
        // dd($today->format('Y-m-d H:i:s'));
        $logs = $logRepository->findByIdDateLogs($yesterday->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'), (int) $request->get('id'));
        $dataS = $dataBuilder->filterLogType($logs, 'seen');
        $dataC = $dataBuilder->filterLogType($logs, 'clicked');
        dd($logs);
        $dataSeen = $dataBuilder->dataPerHours($dataS, $yesterday);
        $dataClick = $dataBuilder->dataPerHours($dataC, $yesterday);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $label,
            'datasets' => [
                [
                    'label' => 'Seen',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $dataSeen,
                ],
                [
                    'label' => 'Click',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $dataClick,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 50,
                ],
            ],
        ]);
        return $this->render('log/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
