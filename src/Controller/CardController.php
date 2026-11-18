<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AllowDynamicProperties]
#[Route("/card")]
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
    #[Route(name: "app_cards")]
    public function index(): Response
    {
        $data = $this->apiService->getAllCards();

        return $this->render("card/index.html.twig", [
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
    #[Route("/id/{id}", name: "app_card", requirements: ["id" => "\d+"])]
    public function getCardById(int $id): Response
    {
        $data = $this->apiService->getCardById($id);
        $card = $data["data"][0];

        return $this->render("card/show/showCard.html.twig", [
            "title" => "Détail de la carte : " . $card["name"],
            "card" => $card,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/level/{level}", name: "app_level", requirements: ["level" => "\d+"])]
    public function getCardsByLevel(int $level, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;

        $data = $this->apiService->getCardsByLevel($level, $num, $offset);

        return $this->render("card/show/showCardByLevel.html.twig", [
            "title" => "Cartes de niveau : " . $level,
            "cards" => $data["data"] ?? [],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            'level' => $level,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/link/{linkval}", name: "app_link", requirements: ["linkval" => "\d+"])]
    public function getCardsByLink(int $linkval, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;

        $data = $this->apiService->getCardsByLink($linkval, $num, $offset);

        return $this->render("card/show/showCardByLinkVal.html.twig", [
            "title" => "Cartes de lien : " . $linkval,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "linkval" => $linkval
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/scale/{scale}", name: "app_scale", requirements: ["scale" => "\d+"])]
    public function getCardsByScale(int $scale, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByScale($scale, $num, $offset);

        return $this->render("card/show/showCardByScale.html.twig", [
            "title" => "Cartes d'Échelle : " . $scale,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            'scale' => $scale,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/atk/{atk}", name: "app_atk", requirements: ["atk" => "\d+"])]
    public function getCardsByAtk(int $atk, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByAtk($atk, $num, $offset);

        return $this->render("card/show/showCardByAtk.html.twig", [
            "title" => "Attaque : " . $atk,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "atk" => $atk
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/def/{def}", name: "app_def", requirements: ["def" => "\d+"])]
    public function getCardsByDef(int $def, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByDef($def, $num, $offset);

        return $this->render("card/show/showCardByDef.html.twig", [
            "title" => "Défense : " . $def,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "def" => $def
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/archetype/{archetype}", name: "app_archetype", requirements: ["archetype" => ".+"]
    )]
    public function getCardsByArchetype(string $archetype, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByArchetype($archetype, $num, $offset);

        return $this->render("card/show/showCardByArchetype.html.twig", [
            "title" => "Archétype : " . $archetype,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "archetype" => $archetype
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/attribute/{attribute}", name: "app_attribute"
    )]
    public function getCardsByAttribute(string $attribute, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByAttribute($attribute, $num, $offset);

        return $this->render("card/show/showCardByAttribute.html.twig", [
            "title" => "Attribut : " . $attribute,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "attribute" => $attribute
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route("/race/{race}", name: "app_race"
    )]
    public function getCardsByRace(string $race, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;
        $data = $this->apiService->getCardsByRace($race, $num, $offset);

        return $this->render("card/show/showCardByRace.html.twig", [
            "title" => "Race : " . $race,
            "cards" => $data["data"],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            "race" => $race
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/type/{type}', name: 'app_type')]
    public function getCardsByType(
        string     $type,
        Request    $request,
        ApiService $apiService
    ): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $num = 20;
        $offset = ($page - 1) * $num;

        $race = $request->query->get('race');

        if ($race !== null) {
            $data = $apiService->getCardsByRaceType($race, $type, $num, $offset);
        } else {
            $data = $apiService->getCardsByType($type, $num, $offset);
        }

        return $this->render('card/show/showCardByType.html.twig', [
            'title' => $race ? "$race $type" : $type,
            'cards' => $data['data'],
            'currentPage' => $page,
            'totalPages' => $data['meta']['total_pages'] ?? 1,
            'type' => $type,
            "race" => $race
        ]);
    }
}
