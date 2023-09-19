<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    #[Route('/ads', name: 'app_ads')]
    public function getTheAds()
    {
        return new JsonResponse(['url' => 'url' , 'lien' => 'lien'], Response::HTTP_OK);
    }

    #[Route('/ads/{id}', name: 'ad_ads')]
    public function getTheAd(Request $request, AdRepository $adRepository)
    {
        $ad = $adRepository->find($request->get('id'));
        return new JsonResponse(['url' => $ad->getImage() , 'lien' => $ad->getLink()], Response::HTTP_OK);
    }

    #[Route('/ad', name: 'app_ad')]
    public function index(AdRepository $adRepository): Response
    {
        $ads = $adRepository->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }
}
