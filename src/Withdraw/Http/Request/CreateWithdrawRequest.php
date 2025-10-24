<?php

declare(strict_types=1);

namespace AbacatePay\Withdraw\Http\Request;

use AbacatePay\Withdraw\Enums\WithdrawMethodsEnum;

final readonly class CreateWithdrawRequest
{
    public function __construct(
        public string $externalId,
        public WithdrawMethodsEnum $method,
        public int $amount,
        public WithdrawPixRequest $pix,
        public ?string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'externalId' => $this->externalId,
            'method' => $this->method->value,
            'amount' => $this->amount,
            'pix' => $this->pix->toArray(),
        ];
    }
}
