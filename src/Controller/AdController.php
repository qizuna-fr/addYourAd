<?php

namespace App\Controller;

use App\Entity\AdCollection;
use App\Service\JsonBuilder;
use App\Service\ImageBuilder;
use Doctrine\ORM\EntityManager;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    #[Route('/random', name: 'app_random')]
    public function randomAds(JsonBuilder $jsonBuilder, AdRepository $adRepository, EntityManager $entityManager)
    {
        $ads = $adRepository->findAll();
        $collection = new AdCollection();
        foreach($ads as $ad)
        {
            $collection->addAd($ad);
        }
        $show = $collection->displayOneRandomly();
        $entityManager->persist($show);
        $entityManager->flush();
        return new JsonResponse(['ad' => ['link' => 'https://127.0.0.1:8000/lien/'.$show->getId(),'image' => 'https://127.0.0.1:8000/base64/'.$show->getId()]], Response::HTTP_OK);
    }



    #[Route('/ads', name: 'app_ads')]
    public function getTheAds(JsonBuilder $jsonBuilder, AdRepository $adRepository)
    {
        $ads = $adRepository->findAll();
        return new JsonResponse($jsonBuilder->stockData($ads), Response::HTTP_OK);
    }

    #[Route('/ads/{id}', name: 'ad_ads')]
    public function getTheAd(Request $request, AdRepository $adRepository)
    {
        $ad = $adRepository->find($request->get('id'));
        return new JsonResponse(['url' => $ad->getImage() , 'lien' => $ad->getLink()], Response::HTTP_OK);
    }

    #[Route('/link', name: 'image_link')]
    public function imageLink()
    {
        return new JsonResponse(['ad' => $this->renderView('api/link.html.twig',['link' => 'lien','image' => 'img'])], Response::HTTP_OK);
    }

    #[Route('/image/{id}', name: 'app_image')]
    public function image(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder)
    {
        $ad = $adRepository->find($request->get('id'));
        return new Response
        (
            file_get_contents($imageBuilder->makeImage($ad)),
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/png'
            ]
        );
    }

    #[Route('/base64/{id}', name: 'app_base64')]
    public function base64(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder)
    {
        $ad = $adRepository->find($request->get('id'));
        return new Response
        (
            $imageBuilder->makeBase64ToImage($ad),
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/png'
            ]
        );
    }

    #[Route('/lien/{id}', name: 'image_lien')]
    public function imageLien(Request $request, AdRepository $adRepository, EntityManager $entityManager)
    {
        $ad = $adRepository->find($request->get('id'));
        if($ad->getLink() != null)
        {
            $ad->oneMoreClick();
            $entityManager->persist($ad);
            $entityManager->flush();
            return new RedirectResponse($ad->getLink());
        }
        else
        {
            return null;
        }
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
