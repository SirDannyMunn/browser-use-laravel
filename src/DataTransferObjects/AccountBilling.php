<?php

namespace BrowserUseLaravel\DataTransferObjects;

class AccountBilling
{
    public function __construct(
        public readonly ?string $name,
        public readonly float $totalCreditsBalanceUsd,
        public readonly float $monthlyCreditsBalanceUsd,
        public readonly float $additionalCreditsBalanceUsd,
        public readonly int $rateLimit,
        public readonly PlanInfo $planInfo,
        public readonly string $projectId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            totalCreditsBalanceUsd: (float) ($data['totalCreditsBalanceUsd'] ?? 0),
            monthlyCreditsBalanceUsd: (float) ($data['monthlyCreditsBalanceUsd'] ?? 0),
            additionalCreditsBalanceUsd: (float) ($data['additionalCreditsBalanceUsd'] ?? 0),
            rateLimit: (int) ($data['rateLimit'] ?? 0),
            planInfo: PlanInfo::fromArray($data['planInfo'] ?? []),
            projectId: $data['projectId'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'totalCreditsBalanceUsd' => $this->totalCreditsBalanceUsd,
            'monthlyCreditsBalanceUsd' => $this->monthlyCreditsBalanceUsd,
            'additionalCreditsBalanceUsd' => $this->additionalCreditsBalanceUsd,
            'rateLimit' => $this->rateLimit,
            'planInfo' => $this->planInfo->toArray(),
            'projectId' => $this->projectId,
        ];
    }
}
