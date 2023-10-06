<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendCSV implements SendFile
{
    public function send(array $logs, Request $request)
    {
        $data = [['type','doneAt']];
        foreach($logs as $log)
        {
            $data[] = [$log['type'],$log['done_at']];
        }

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
}