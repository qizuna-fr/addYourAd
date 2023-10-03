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
        $logs = $logRepository->findByIdDateLogs($yesterday, $today, (int) $request->get('id'));
        $data = $dataBuilder->separator($logs);
        dd($label);
        $dataSeen = $dataBuilder->dataPerHours($data['seen'], $yesterday);
        $dataClick = $dataBuilder->dataPerHours($data['click'], $yesterday);
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
