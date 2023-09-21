<?php

namespace App\Service;

class JsonBuilder
{
    public function stockData(?array $ads)
    {
        $datas = [];
        foreach($ads as $ad)
        {
            $datas[] = ['url' => $ad->getImage() , 'lien' => $ad->getLink()];
        }
        return $datas;
    }
}