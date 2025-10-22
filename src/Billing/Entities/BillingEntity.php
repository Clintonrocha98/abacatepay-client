<?php

declare(strict_types=1);

namespace AbacatePay\Billing\Entities;

use AbacatePay\Billing\Enum\AbacatePayBillingFrequencyEnum;
use AbacatePay\Billing\Enum\AbacatePayBillingMethodEnum;
use AbacatePay\Billing\Enum\AbacatePayBillingStatusEnum;
use AbacatePay\Customer\Entities\CustomerEntity;
use JsonSerializable;

final readonly class BillingEntity implements JsonSerializable
{
    /**
     * @param  AbacatePayBillingMethodEnum[]  $methods
     * @param  BillingProductEntity[]  $products
     * @param  string[]  $coupons
     */
    public function __construct(
        public string $id,
        public string $url,
        public int $amount,
        public AbacatePayBillingStatusEnum $status,
        public bool $dev_mode,
        public array $methods,
        public array $products,
        public AbacatePayBillingFrequencyEnum $frequency,
        public ?string $next_billing,
        public CustomerEntity $customer,
        public bool $allow_coupons,
        public array $coupons,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            url: $data['url'],
            amount: $data['amount'],
            status: AbacatePayBillingStatusEnum::from($data['status']),
            dev_mode: $data['devMode'],
            methods: array_map(
                fn ($method) => AbacatePayBillingMethodEnum::from($method),
                $data['methods']
            ),
            products: array_map(
                fn (array $product) => BillingProductEntity::fromArray($product),
                $data['products']
            ),
            frequency: AbacatePayBillingFrequencyEnum::from($data['frequency']),
            next_billing: $data['nextBilling'],
            customer: CustomerEntity::fromArray($data['customer']),
            allow_coupons: $data['allowCoupons'],
            coupons: $data['coupons'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'amount' => $this->amount,
            'status' => $this->status->value,
            'devMode' => $this->dev_mode,
            'methods' => array_map(fn ($m) => $m->value, $this->methods),
            'products' => array_map(
                fn (BillingProductEntity $product) => $product->jsonSerialize(),
                $this->products
            ),
            'frequency' => $this->frequency->value,
            'nextBilling' => $this->next_billing,
            'customer' => $this->customer->jsonSerialize(),
            'allowCoupons' => $this->allow_coupons,
            'coupons' => $this->coupons,
        ];
    }
}
