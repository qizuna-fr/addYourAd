<?php

namespace App\Controller;

use App\Entity\Log;
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
    public function randomAds(
        JsonBuilder $jsonBuilder,
        AdRepository $adRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $ads = $adRepository->findAll();
        $collection = new AdCollection();
        foreach ($ads as $ad) {
            $collection->addAd($ad);
        }
        $show = $collection->displayOneRandomly();

        $entityManager->persist($show);
        $entityManager->flush();

        $log = new Log();
        $log->setSeen($show);

        $entityManager->persist($log);
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
            ],
            Response::HTTP_OK
        );
    }
    #[Route('/api/ad/image/{id}', name: 'app_base64', schemes: ['https'])]
    public function base64(Request $request, AdRepository $adRepository, ImageBuilder $imageBuilder): Response
    {
        $ad = $adRepository->find($request->get('id'));
        if ($ad == null) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        return new Response(
            $imageBuilder->makeBase64ToImage($ad),
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/png',
            ]
        );
    }

    #[Route('api/ad/link/{id}', name: 'image_lien', schemes: ['https'])]
    public function imageLien(
        Request $request,
        AdRepository $adRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $ad = $adRepository->find($request->get('id'));
        if ($ad === null) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $ad->oneMoreClick();
        $entityManager->persist($ad);
        $entityManager->flush();

        $log = new Log();
        $log->setClick($ad);

        $entityManager->persist($log);
        $entityManager->flush();

        return new RedirectResponse($ad->getLink());
    }
}
