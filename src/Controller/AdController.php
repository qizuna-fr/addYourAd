<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    #[Route('/ad', name: 'app_ad')]
    public function index(AdRepository $adRepository): Response
    {
        $ads = $adRepository->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }
}
