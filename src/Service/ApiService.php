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
    private const string BASE_URL = 'https://db.ygoprodeck.com/api/v7/';
    private const string ENDPOINT_ALL = 'cardinfo.php';
    private const string ENDPOINT_RANDOM = 'randomcard.php';

    private const array CARD_TYPES = [
        'normal' => [
            'type' => 'normal monster',
        ],
        'normal_tuner' => [
            'type' => 'Normal Tuner monster',
        ],
        'effect' => [
            'type' => 'effect monster',
        ],
        'tuner' => [
            'type' => 'Tuner monster',
        ],
        'flip' => [
            'type' => 'flip monster',
        ],
        'spirit' => [
            'type' => 'spirit monster',
        ],
        'union_effect' => [
            'type' => 'union effect monster',
        ],
        'gemini' => [
            'type' => 'Gemini monster',
        ],
        'pendulum_normal' => [
            'type' => 'pendulum normal monster',
        ],
        'pendulum_effect' => [
            'type' => 'pendulum effect monster',
        ],
        'pendulum_effect_ritual' => [
            'type' => 'pendulum effect ritual monster',
        ],
        'pendulum_tuner_effect' => [
            'type' => 'pendulum tuner effect monster',
        ],
        'pendulum_flip_effect' => [
            'type' => 'pendulum flip effect monster',
        ],
        'ritual' => [
            'type' => 'ritual monster',
        ],
        'ritual_effect' => [
            'type' => 'ritual effect monster',
        ],
        'toon' => [
            'type' => 'toon monster',
        ],
        'fusion' => [
            'type' => 'fusion monster',
            'offset' => 1,
        ],
        'fusion_pendulum_effect' => [
            'type' => 'pendulum effect fusion monster',
            'offset' => 1,
        ],
        'synchro' => [
            'type' => 'synchro monster',
            'offset' => 1,
        ],
        'synchro_tuner' => [
            'type' => 'synchro tuner monster',
            'offset' => 1,
        ],
        'synchro_pendulum_effect' => [
            'type' => 'synchro pendulum effect monster',
            'offset' => 1,
        ],
        'xyz' => [
            'type' => 'xyz monster',
            'offset' => 1,
        ],
        'xyz_pendulum_effect' => [
            'type' => 'xyz pendulum effect monster',
            'offset' => 1,
        ],
        'link' => [
            'type' => 'link monster',
            'offset' => 1,
        ],
        'normal_spell' => [
            'race' => 'normal',
            'type' => 'spell card',
            'offset' => 1,
        ],
        'continuous_spell' => [
            'race' => 'continuous',
            'type' => 'spell card',
        ],
        'ritual_spell' => [
            'race' => 'ritual',
            'type' => 'spell card',
        ],
        'quickplay_spell' => [
            'race' => 'quick-play',
            'type' => 'spell card',
        ],
        'field_spell' => [
            'race' => 'field',
            'type' => 'spell card',
        ],
        'equip_spell' => [
            'race' => 'equip',
            'type' => 'spell card',
        ],
        'normal_trap' => [
            'race' => 'normal',
            'type' => 'trap card',
        ],
        'continuous_trap' => [
            'race' => 'continuous',
            'type' => 'trap card',
        ],
        'counter_trap' => [
            'race' => 'counter',
            'type' => 'trap card',
        ],
    ];

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function request(string $endpoint, array $query = []): array
    {
        $response = $this->client->request(
            'GET',
            self::BASE_URL . $endpoint,
            ['query' => $query]
        );

        return $response->toArray();
    }

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

        foreach (self::CARD_TYPES as $type => $params) {
            $query = array_replace([
                'num' => 1,
                'offset' => 0,
            ], $params);

            $data = $this->request(self::ENDPOINT_ALL, $query);

            $cards[$type] = $data['data'][0] ?? null;
        }

        return array_filter($cards);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getRandomCard(): array
    {
        return $this->request(self::ENDPOINT_RANDOM);

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
        return $this->request(self::ENDPOINT_ALL, [
            'id' => $id,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByLevel(int $level): array
    {
        return $this->request(self::ENDPOINT_ALL, [
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
    public function getCardsByLink(int $link): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'link' => $link,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByScale(int $scale): array
    {
        return $this->request(self::ENDPOINT_ALL, [
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
    public function getCardsByAtk(int $atk): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'atk' => $atk,
        ]);
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByDef(int $def): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'def' => $def,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByArchetype(string $archetype): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'archetype' => $archetype,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByType(string $type): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'type' => $type,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByRace(string $race): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'race' => $race,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByRaceType(string $race, string $type): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            "race" => $race,
            "type" => $type,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCardsByAttribute(string $attribute): array
    {
        return $this->request(self::ENDPOINT_ALL, [
            'attribute' => $attribute,
        ]);
    }
}
