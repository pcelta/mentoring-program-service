<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class HealthCheckController extends AbstractController
{
    /**
     * @Route("/health/check", name="health-check", methods={"GET","HEAD"})
     */
    public function check(Request $request): JsonResponse
    {
        $now = new DateTime('now');

        $responseBody = [
            'message' => 'Its all good m8! Your DNX Mentoring App is up and running!',
            'datetime' => $now->format('Y-m-d H:i:s')
        ];

        return new JsonResponse($responseBody);
    }
}
