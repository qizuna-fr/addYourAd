<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

interface SendFile
{
    public function send(array $data, Request $request);
}