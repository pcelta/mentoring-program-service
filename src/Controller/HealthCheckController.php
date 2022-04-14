<?php

namespace App\Controller;

use DateTime;
use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController extends AbstractController
{
    /**
     * @Route("/health/check", name="health-check", methods={"GET","HEAD"})
     */
    public function check(Request $request): JsonResponse
    {
        $now = new DateTime('now');
        $message = 'It is all good m8! Your Mentoring Program Service is up and running!';
        $statusCode = Response::HTTP_OK;

        try {
            $this->checkDatabaseConnection();
        } catch (PDOException $e) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Oops! It seems like there is something wrong with te Database connection. =/';
        }

        $responseBody = [
            'message' => $message,
            'datetime' => $now->format('Y-m-d H:i:s')
        ];

        return new JsonResponse($responseBody, $statusCode);
    }

    private function checkDatabaseConnection(): void
    {
        $host = $this->getParameter('db.host');
        $port = $this->getParameter('db.port');
        $dbName = $this->getParameter('db.name');
        $username = $this->getParameter('db.username');
        $password = $this->getParameter('db.password');

        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8mb4";

        new PDO($dsn, $username, $password);
    }
}
