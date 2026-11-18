<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AllowDynamicProperties]
final class HomeController extends AbstractController
{
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }


    #[Route("/", name: "app_home")]
    public function index(): Response
    {
        return $this->render("home/index.html.twig", [
            "title" => "Home",
        ]);
    }

}
