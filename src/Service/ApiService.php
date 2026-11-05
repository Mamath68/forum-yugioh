<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ApiService
{
    private const string BASE_URL = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';

    private const array URLS = [
        'normal' => self::BASE_URL . "?type=normal%20monster&num=1&offset=0",
        'effect' => self::BASE_URL . "?type=effect%20monster&num=1&offset=0",
        'rituel' => self::BASE_URL . "?type=ritual%20monster&num=1&offset=0",
        'fusion' => self::BASE_URL . "?type=fusion%20monster&num=1&offset=1",
        'normal_spell' => self::BASE_URL . "?race=normal&type=spell%20card&num=1&offset=1",
        'continuous_spell' => self::BASE_URL . "?race=continuous&type=spell%20card&num=1&offset=0",
        'normal_trap' => self::BASE_URL . "?race=normal&type=trap%20card&num=1&offset=0",
        'continuous_trap' => self::BASE_URL . "?race=continuous&type=trap%20card&num=1&offset=0",
    ];

    public function __construct(
        private HttpClientInterface $client
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAllCards(): array
    {
        $cards = [];

        foreach (self::URLS as $type => $url) {
            $response = $this->client->request('GET', $url);

            $data = $response->toArray();

            $cards[$type] = $data['data'][0] ?? null;
        }

        return $cards;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardById(int $id): array
    {
        $response = $this->client->request(
            "GET",
            self::BASE_URL, [
                "query" => [
                    "id" => $id,
                ],]
        );

        return $response->toArray();
    }
}
