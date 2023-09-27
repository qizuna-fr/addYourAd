<?php

namespace App\Controller;

use App\Entity\AdCollection;
use App\Service\JsonBuilder;
use App\Service\ImageBuilder;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    #[Route('/api/ad/random', name: 'app_random')]
    #[Route('/api/ad/random', name: 'app_random')]
    public function randomAds(
        JsonBuilder $jsonBuilder,
        AdRepository $adRepository,
        EntityManagerInterface $entityManager
    ) {
        $ads = $adRepository->findAll();
        $collection = new AdCollection();
        foreach ($ads as $ad) {
            $collection->addAd($ad);
        }
        $show = $collection->displayOneRandomly();
        $entityManager->persist($show);
        $entityManager->flush();
        return new JsonResponse(
            [
                'ad' => [
                    'link' => $this->generateUrl(
                        'image_lien',
                        ['id' => $show->getId()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                    'image' => $this->generateUrl(
                        'app_base64',
                        ['id' => $show->getId()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                ],
            ], Response::HTTP_OK
        );
    }


//    #[Route('/ads/{id}', name: 'ad_ads')]
//    public function getTheAd(Request $request, AdRepository $adRepository)
//    {
//        $ad = $adRepository->find($request->get('id'));
//        return new JsonResponse(['url' => $ad->getImage(), 'lien' => $ad->getLink()], Response::HTTP_OK);
//    }
//    #[Route('/ads/{id}', name: 'ad_ads')]
//    public function getTheAd(Request $request, AdRepository $adRepository)
//    {
//        $ad = $adRepository->find($request->get('id'));
//        return new JsonResponse(['url' => $ad->getImage(), 'lien' => $ad->getLink()], Response::HTTP_OK);
//    }

//    #[Route('/link', name: 'image_link')]
//    public function imageLink()
//    {
//        return new JsonResponse(['ad' => $this->renderView('api/link.html.twig', ['link' => 'lien', 'image' => 'img'])],
//                                Response::HTTP_OK);
//    }
//    #[Route('/link', name: 'image_link')]
//    public function imageLink()
//    {
//        return new JsonResponse(['ad' => $this->renderView('api/link.html.twig', ['link' => 'lien', 'image' => 'img'])],
//                                Response::HTTP_OK);
//    }

//    #[Route('api/image/{id}', name: 'app_image')]
//    public function image(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder)
//    {
//        $ad = $adRepository->find($request->get('id'));
//        return new Response
//        (
//            file_get_contents($imageBuilder->makeImage($ad)),
//            Response::HTTP_OK,
//            [
//                'Content-Type' => 'image/png',
//            ]
//        );
//    }
//    #[Route('api/image/{id}', name: 'app_image')]
//    public function image(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder)
//    {
//        $ad = $adRepository->find($request->get('id'));
//        return new Response
//        (
//            file_get_contents($imageBuilder->makeImage($ad)),
//            Response::HTTP_OK,
//            [
//                'Content-Type' => 'image/png',
//            ]
//        );
//    }

    #[Route('/api/ad/image/{id}', name: 'app_base64' , schemes: ['https'])]
    #[Route('/api/ad/image/{id}', name: 'app_base64' , schemes: ['https'])]
    public function base64(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder)
    {
        $ad = $adRepository->find($request->get('id'));
        if ($ad === null){
            return new Response(null, Response::HTTP_NOT_FOUND );
        }

        if ($ad === null){
            return new Response(null, Response::HTTP_NOT_FOUND );
        }

        return new Response
        (
            $imageBuilder->makeBase64ToImage($ad),
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/png',
            ]
        );
    }

    #[Route('api/ad/link/{id}', name: 'image_lien' , schemes: ['https'])]
    #[Route('api/ad/link/{id}', name: 'image_lien' , schemes: ['https'])]
    public function imageLien(Request $request, AdRepository $adRepository, EntityManagerInterface $entityManager)
    {
        $ad = $adRepository->find($request->get('id'));
        if ($ad === null){
            return new Response(null, Response::HTTP_NOT_FOUND );
        }

        $ad->oneMoreClick();
        $entityManager->persist($ad);
        $entityManager->flush();

        return new RedirectResponse($ad->getLink());
    }

//    #[Route('/ad', name: 'app_ad')]
//    public function index(AdRepository $adRepository): Response
//    {
//        $ads = $adRepository->findAll();
//        return $this->render('ad/index.html.twig', [
//            'ads' => $ads,
//        ]);
//    }
        if ($ad === null){
            return new Response(null, Response::HTTP_NOT_FOUND );
        }

        $ad->oneMoreClick();
        $entityManager->persist($ad);
        $entityManager->flush();

        return new RedirectResponse($ad->getLink());
    }

//    #[Route('/ad', name: 'app_ad')]
//    public function index(AdRepository $adRepository): Response
//    {
//        $ads = $adRepository->findAll();
//        return $this->render('ad/index.html.twig', [
//            'ads' => $ads,
//        ]);
//    }
}