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
#[Route('/card')]
final class CardController extends AbstractController
{
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route(name: 'app_cards')]
    public function index(): Response
    {
        $data = $this->apiService->getAllCards();

        return $this->render('card/index.html.twig', [
            "title" => "Les Cartes",
            "cards" => $data,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/id/{id}", name: 'app_card', requirements: ['id' => '\d+'])]
    public function getCardById(int $id): Response
    {
        $data = $this->apiService->getCardById($id);
        $card = $data['data'][0];

        return $this->render('card/show/showCard.html.twig', [
            'title' => 'Détail de la carte : ' . $card["name"],
            'card' => $card,
        ]);
    }
}
