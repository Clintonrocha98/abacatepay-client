<?php

namespace AbacatePay\Billing\Http\Response;

use AbacatePay\Billing\Collection\BillingEntityCollection;

final readonly class ListBillingResponse
{
    public function __construct(
        public BillingEntityCollection $data,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            data: BillingEntityCollection::fromArray($data['data']),
        );
    }
}
