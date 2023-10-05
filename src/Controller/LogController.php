<?php

namespace App\Controller;

use DateInterval;
use SimpleXMLElement;
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
    #[Route('/log/charts/today/{id}', name: 'app_log')]
    public function logTodayCharts(Request $request, ChartBuilderInterface $chartBuilder, LabelBuilder $labelBuilder, DataBuilder $dataBuilder, LogRepository $logRepository): Response
    {
        $today = new DateTimeImmutable();
        $newToday = $today->setTime((int) $today->format('H'), 0, 0);
        $yesterday = $newToday->sub(new DateInterval('P1D'));
        $label = $labelBuilder->hoursLabelFromYesterday($yesterday, $today);
        // dd($today->format('Y-m-d H:i:s'));
        $logs = $logRepository->findByIdDateLogs($yesterday->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'), (int) $request->get('id'));
        $dataS = $dataBuilder->filterLogType($logs, 'seen');
        $dataC = $dataBuilder->filterLogType($logs, 'clicked');
        // dd($logs);
        $dataSeen = $dataBuilder->dataPerHours($dataS, $yesterday);
        $dataClick = $dataBuilder->dataPerHours($dataC, $yesterday);
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
        return $this->render('log/index.html.twig', [
            'chart' => $chart,
        ]);
    }

    #[Route('/log/csv/today/{id}', name: 'csv_log')]
    public function logTodayCSV(Request $request, LabelBuilder $labelBuilder, DataBuilder $dataBuilder, LogRepository $logRepository): Response
    {
        $today = new DateTimeImmutable();
        $newToday = $today->setTime((int) $today->format('H'), 0, 0);
        $yesterday = $newToday->sub(new DateInterval('P1D'));
        $label = $labelBuilder->hoursLabelFromYesterday($yesterday, $today);
        $logs = $logRepository->findByIdDateLogs($yesterday->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'), (int) $request->get('id'));
        $data = $dataBuilder->oneAdLogForCSV($logs);

        // mettre le moyen de stocker $data dans un fichier csv

        $csvFile = tempnam(sys_get_temp_dir(), 'log_') . '.csv';
        $fileHandle = fopen($csvFile, 'w');
        // dd($data);
        foreach ($data as $row) {
            fputcsv($fileHandle, $row, ';');
        }
        fclose($fileHandle);

        $response = new Response();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="log'.$request->get('id').'.csv"');
        header('Content-Length: ' . filesize($csvFile));
        readfile($csvFile);

        unlink($csvFile);

        return $response;
    }

    #[Route('/log/xml/today/{id}', name: 'xml_log')]
    public function logTodayXML(Request $request, LabelBuilder $labelBuilder, DataBuilder $dataBuilder, LogRepository $logRepository): Response
    {
        $today = new DateTimeImmutable();
        $newToday = $today->setTime((int) $today->format('H'), 0, 0);
        $yesterday = $newToday->sub(new DateInterval('P1D'));
        $label = $labelBuilder->hoursLabelFromYesterday($yesterday, $today);
        $logs = $logRepository->findByIdDateLogs($yesterday->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'), (int) $request->get('id'));
        $data = $dataBuilder->oneAdLogForXML($logs);

        // mettre le moyen de stocker $data dans un fichier xml

        $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        foreach ($data as $item) {
            $log = $xml->addChild('log');
            foreach ($item['log'] as $key => $value) {
                $log->addChild($key, htmlspecialchars("$value"));
            }
        }
        $xmlContent = $xml->asXML();

        $response = new Response($xmlContent);
        $response->headers->set('Content-Type', 'text/xml');
        $response->headers->set('Content-Disposition', 'attachment; filename="log'.$request->get('id').'.xml"');

        return $response;
    }
}
