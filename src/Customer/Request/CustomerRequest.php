<?php

declare(strict_types=1);

namespace AbacatePay\Customer\Request;

final readonly class CustomerRequest
{
    public function __construct(
        public string $id,
        public CustomerMetadata $meta_data,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'metadata' => $this->meta_data,
        ];
    }
}
