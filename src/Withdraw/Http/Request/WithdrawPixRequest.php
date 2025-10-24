<?php

declare(strict_types=1);

namespace AbacatePay\Withdraw\Http\Request;

use AbacatePay\Withdraw\Enums\WithdrawPixTypeEnum;

final readonly class WithdrawPixRequest
{
    public function __construct(
        public WithdrawPixTypeEnum $type,
        public string $key
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'key' => $this->key,
        ];
    }
}
