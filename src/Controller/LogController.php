<?php

namespace App\Controller;

use DateInterval;
use SimpleXMLElement;
use DateTimeImmutable;
use App\Service\SendCSV;
use App\Service\SendXML;
use App\Service\LogBuilder;
use App\Service\DataBuilder;
use App\Service\DateBuilder;
use App\Service\LabelBuilder;
use App\Repository\AdRepository;
use App\Repository\LogRepository;
use App\Service\ChartsDataBuilder;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogController extends AbstractController
{
    private AdRepository $adRepository;
    private LogRepository $logRepository;
    private DataBuilder $dataBuilder;
    private LogBuilder $logBuilder;
    private DateBuilder $dateBuilder;
    private LabelBuilder $labelBuilder;
    private ChartsDataBuilder $chartsDataBuilder;
    private ChartBuilderInterface $chartBuilder;
    private Request $request;

    public function __construct(
        AdRepository $adRepository,
        LogRepository $logRepository,
        DataBuilder $dataBuilder,
        LogBuilder $logBuilder,
        DateBuilder $dateBuilder,
        LabelBuilder $labelBuilder,
        ChartsDataBuilder $chartsDataBuilder,
        ChartBuilderInterface $chartBuilder,
        )
    {
        $this->adRepository = $adRepository;
        $this->logRepository = $logRepository;
        $this->dataBuilder = $dataBuilder;
        $this->dateBuilder = $dateBuilder;
        $this->logBuilder = $logBuilder;
        $this->labelBuilder = $labelBuilder;
        $this->chartsDataBuilder = $chartsDataBuilder;
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/log/charts/today/{id}/', name: 'charts_today_log')]
    public function logTodayCharts(Request $request): Response
    {
        $today = new DateTimeImmutable();
        $newToday = $today->setTime((int) $today->format('H'), 0, 0);
        $yesterday = $newToday->sub(new DateInterval('P1D'));
        $label = $this->labelBuilder->hoursLabelFromYesterday($yesterday, $today);
        $logs = $this->logRepository->findByIdDateLogs($yesterday->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'), (int) $request->get('id'));
        $dataSeen = $this->dataBuilder->dataPerHours($this->dataBuilder->filterLogType($logs, 'seen'), $yesterday);
        $dataClick = $this->dataBuilder->dataPerHours($this->dataBuilder->filterLogType($logs, 'clicked'), $yesterday);
        $chart = $this->chartsDataBuilder->makeChartsData($label, $dataClick, $dataSeen, $this->chartBuilder);
        return $this->render('log/today.html.twig', [
            'todayChart' => $chart,
        ]);
    }

    #[Route('/log/charts/all/{id}/', name: 'charts_all_log')]
    public function logAllCharts(Request $request): Response
    {
        $label = $this->labelBuilder->hoursLabelForAll();
        $logs = $this->logRepository->findByIdLogs((int) $request->get('id'));
        $dataSeen = $this->dataBuilder->allDataPerHours($this->dataBuilder->filterLogType($logs, 'seen'));
        // dd($dataSeen);
        $dataClick = $this->dataBuilder->allDataPerHours($this->dataBuilder->filterLogType($logs, 'clicked'));
        $chart = $this->chartsDataBuilder->makeChartsData($label, $dataClick, $dataSeen, $this->chartBuilder);
        return $this->render('log/all.html.twig', [
            'allChart' => $chart,
        ]);
    }

    #[Route('/log/csv/all/{id}', name: 'csv_all_log')]
    public function logAllCSV(Request $request, SendCSV $sendCSV): Response
    {
        $logs = $this->logBuilder->createLogsAll($this->dateBuilder, $this->logRepository, $this->adRepository, (int) $request->get('id'));

        $response = $sendCSV->send($logs, $request);

        return $response;
    }

    #[Route('/log/xml/all/{id}', name: 'xml_all_log')]
    public function logAllXML(Request $request, SendXML $sendXML): Response
    {
        $logs = $this->logBuilder->createLogsAll($this->dateBuilder, $this->logRepository, $this->adRepository, (int) $request->get('id'));

        $response = $sendXML->send($logs, $request);

        return $response;
    }
}
