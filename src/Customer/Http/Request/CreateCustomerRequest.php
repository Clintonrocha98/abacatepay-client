<?php

declare(strict_types=1);

namespace AbacatePay\Customer\Http\Request;

use JsonSerializable;

final readonly class CreateCustomerRequest implements JsonSerializable
{
    public function __construct(
        public string $name,
        public string $cellphone,
        public string $email,
        public string $tax_id,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
            'tax_id' => $this->tax_id,
        ];
    }
}
