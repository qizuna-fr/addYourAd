<?php

namespace App\Service;

use App\Entity\Ad;

class JsonBuilder
{
    /**
     * @param Ad[]|null $ads
     * @return array<string, string>[]
     */
    public function stockData(?array $ads): array
    {
        $datas = [];
        foreach ($ads as $ad) {
            $datas[] = ['url' => $ad->getImage() , 'lien' => $ad->getLink()];
        }
        return $datas;
    }
}
