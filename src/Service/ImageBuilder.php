<?php

namespace App\Service;

use App\Entity\Ad;

class ImageBuilder
{
    public function makeImage(Ad $ad)
    {
        $path = 'img/uploads/';
        return $imagePath = $path.$ad->getImage();
    }
}