<?php

namespace App\Service;

use App\Entity\Ad;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class ChartsDataBuilder
{
    public function makeChartsData(array $label, array $dataClick, array $dataSeen, ChartBuilderInterface $chartBuilder)
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $label,
            'datasets' => [
                [
                    'label' => 'Click',
                    'backgroundColor' => '#707070',
                    'borderColor' => '#707070',
                    'data' => $dataClick,
                ],
                [
                    'type' => 'bar',
                    'label' => 'Seen',
                    'backgroundColor' => '#009ee2',
                    'borderColor' => '#009ee2',
                    'data' => $dataSeen,
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
        return $chart;
    }
}
