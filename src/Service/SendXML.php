<?php

namespace App\Service;

use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendXML implements SendFile
{
    public function send(array $logs, Request $request)
    {
        $data = [];
        foreach($logs as $log)
        {
            $data[] = ['log' => ['type' => $log['type'], 'doneAt' => $log['done_at']]];
        }

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