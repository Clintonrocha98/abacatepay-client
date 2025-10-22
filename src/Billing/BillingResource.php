<?php

declare(strict_types=1);

use AbacatePay\Billing\Request\CreateBillingRequest;
use AbacatePay\Billing\Response\CreateBillingResponse;
use AbacatePay\Billing\Response\ListBillingResponse;
use AbacatePay\Exception\AbacatePayException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

final class BillingResource
{
    public const string BASE_URI = 'https://api.abacatepay.com/v1/billing';

    public function __construct(
        private readonly Client $client,
    ) {}

    /**
     * @throws AbacatePayException
     * @throws JsonException
     */
    public function create(CreateBillingRequest $request): CreateBillingResponse
    {
        try {
            $response = $this->client->post(self::BASE_URI.'/create', [
                'json' => $request->jsonSerialize(),
            ]);

            $responsePayload = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return CreateBillingResponse::fromArray($responsePayload);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw AbacatePayException::unauthorized(),
                default => throw new AbacatePayException($e->getMessage(), $e->getCode()),
            };
        }
    }

    /**
     * @throws AbacatePayException
     * @throws JsonException
     */
    public function list(): ListBillingResponse
    {
        try {
            $response = $this->client->get(self::BASE_URI.'/list');

            $responsePayload = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return ListBillingResponse::fromArray($responsePayload);

        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw AbacatePayException::unauthorized(),
                default => throw new AbacatePayException($e->getMessage(), $e->getCode()),
            };
        }
    }
}
