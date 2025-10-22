<?php

declare(strict_types=1);

namespace AbacatePay\Customer;

use AbacatePay\Customer\Entities\CreateCustomerRequest;
use AbacatePay\Customer\Entities\CreateCustomerResponse;
use AbacatePay\Customer\Entities\CustomerEntityCollection;
use AbacatePay\Exception\AbacatePayException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

final class CustomerResource
{
    public const string BASE_URI = 'https://api.abacatepay.com/v1/customer';

    public function __construct(
        private readonly Client $client,
    ) {}

    /**
     * @throws AbacatePayException
     * @throws JsonException
     */
    public function create(CreateCustomerRequest $request): CreateCustomerResponse
    {
        try {
            $response = $this->client->post(self::BASE_URI.'/create', [
                'json' => $request->toArray(),
            ]);

            $responsePayload = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return CreateCustomerResponse::fromArray($responsePayload);
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
    public function list(): CustomerEntityCollection
    {
        try {
            $response = $this->client->get(self::BASE_URI.'/list');
            $responsePayload = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return CustomerEntityCollection::fromArray($responsePayload['data']);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw AbacatePayException::unauthorized(),
                default => throw new AbacatePayException($e->getMessage(), $e->getCode()),
            };
        }
    }
}
