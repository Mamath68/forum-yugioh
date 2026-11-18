<?php

namespace App\Twig\Components;

use AllowDynamicProperties;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Service\ApiService;

#[AllowDynamicProperties]
#[AsTwigComponent]
final class RandomCard
{
    public function __construct(private readonly ApiService $apiService)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function mount(): void
    {
        $this->card = $this->apiService->getRandomCard()['data'][0];
    }
}
