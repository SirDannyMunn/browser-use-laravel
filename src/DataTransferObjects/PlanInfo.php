<?php

namespace BrowserUseLaravel\DataTransferObjects;

class PlanInfo
{
    public function __construct(
        public readonly string $planName,
        public readonly ?string $subscriptionStatus,
        public readonly ?string $subscriptionId,
        public readonly ?string $subscriptionCurrentPeriodEnd,
        public readonly ?string $subscriptionCanceledAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            planName: $data['planName'] ?? '',
            subscriptionStatus: $data['subscriptionStatus'] ?? null,
            subscriptionId: $data['subscriptionId'] ?? null,
            subscriptionCurrentPeriodEnd: $data['subscriptionCurrentPeriodEnd'] ?? null,
            subscriptionCanceledAt: $data['subscriptionCanceledAt'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'planName' => $this->planName,
            'subscriptionStatus' => $this->subscriptionStatus,
            'subscriptionId' => $this->subscriptionId,
            'subscriptionCurrentPeriodEnd' => $this->subscriptionCurrentPeriodEnd,
            'subscriptionCanceledAt' => $this->subscriptionCanceledAt,
        ];
    }
}
