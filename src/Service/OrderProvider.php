<?php

namespace AppPaymentClient\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderProvider
{
    /**
     * @var ServiceUrlsProvider
     */
    private $serviceUrlsProvider;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        ServiceUrlsProvider $serviceUrlsProvider,
        HttpClientInterface $httpClient,
        RequestStack $requestStack
    )
    {
        $this->serviceUrlsProvider = $serviceUrlsProvider;
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return null;
        }
        $url = $this->serviceUrlsProvider->getOrderUrl();
        if (empty($url)) {
            return null;
        }
        try {
            $response = $this->httpClient->request('GET', $request->getSchemeAndHttpHost() . $url);
            $data = json_decode($response->getContent(), true);
            return $data['data']['id'] ?? null;
        } catch (TransportExceptionInterface | ClientExceptionInterface
            | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            return null;
        }
    }
}