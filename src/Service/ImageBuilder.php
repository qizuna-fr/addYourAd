<?php

namespace App\Service;

use App\Entity\Ad;

class ImageBuilder
{
    public function makeImage(Ad $ad)
    {
        $path = 'img/uploads/';
        return $imagePath = $path . $ad->getImage();
    }

    public function makeBase64ToImage(Ad $ad)
    {
        return base64_decode($ad->getImageBase64());
    }
}
