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
            'title' => "Détail de la carte : " . $card["name"],
            'card' => $card,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/level/{level}", name: 'app_level', requirements: ['level' => '\d+'])]
    public function getCardsByLevel(int $level): Response
    {
        $data = $this->apiService->getCardsByLevel($level);

        return $this->render('card/show/showCardByLevel.html.twig', [
            'title' => "Cartes de niveau : " . $level,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/link/{linkval}", name: 'app_link', requirements: ['linkval' => '\d+'])]
    public function getCardsByLink(int $linkval): Response
    {
        $data = $this->apiService->getCardsByLink($linkval);

        return $this->render('card/show/showCardByLinkVal.html.twig', [
            'title' => "Cartes de lien : " . $linkval,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/scale/{scale}", name: 'app_scale', requirements: ['scale' => '\d+'])]
    public function getCardsByScale(int $scale): Response
    {
        $data = $this->apiService->getCardsByScale($scale);

        return $this->render('card/show/showCardByScale.html.twig', [
            'title' => "Cartes d'Échelle' : " . $scale,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/atk/{atk}", name: 'app_atk', requirements: ['atk' => '\d+'])]
    public function getCardsByAtk(int $atk): Response
    {
        $data = $this->apiService->getCardsByAtk($atk);

        return $this->render('card/show/showCardByAtk.html.twig', [
            'title' => "Attaque' : " . $atk,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/def/{def}", name: 'app_def', requirements: ['def' => '\d+'])]
    public function getCardsByDef(int $def): Response
    {
        $data = $this->apiService->getCardsByDef($def);

        return $this->render('card/show/showCardByDef.html.twig', [
            'title' => "Défense' : " . $def,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/archetype/{archetype}", name: 'app_archetype',     requirements: ['archetype' => '.+']
    )]
    public function getCardsByArchetype(string $archetype): Response
    {
        $data = $this->apiService->getCardsByArchetype($archetype);

        return $this->render('card/show/showCardByArchetype.html.twig', [
            'title' => "Archétype' : " . $archetype,
            'cards' => $data["data"],
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/attribute/{attribute}", name: 'app_attribute'
    )]
    public function getCardsByAttribute(string $attribute): Response
    {
        $data = $this->apiService->getCardsByAttribute($attribute);

        return $this->render('card/show/showCardByAttribute.html.twig', [
            'title' => "Attribut' : " . $attribute,
            'cards' => $data["data"],
        ]);
    }
}
