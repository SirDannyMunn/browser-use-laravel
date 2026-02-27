<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Account
{
    public function __construct(
        public readonly string $id,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $profileId,
        public readonly string $provider,
        public readonly string $accountKey,
        public readonly ?string $description,
        public readonly bool $hasUsername,
        public readonly bool $hasPassword,
        public readonly bool $hasTotpSeed,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        return new self(
            id: (string) ($payload['id'] ?? ''),
            createdAt: (string) ($payload['createdAt'] ?? ''),
            updatedAt: (string) ($payload['updatedAt'] ?? ''),
            profileId: (string) ($payload['profileId'] ?? ''),
            provider: (string) ($payload['provider'] ?? ''),
            accountKey: (string) ($payload['accountKey'] ?? ''),
            description: isset($payload['description']) ? (string) $payload['description'] : null,
            hasUsername: (bool) ($payload['hasUsername'] ?? false),
            hasPassword: (bool) ($payload['hasPassword'] ?? false),
            hasTotpSeed: (bool) ($payload['hasTotpSeed'] ?? false),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'profileId' => $this->profileId,
            'provider' => $this->provider,
            'accountKey' => $this->accountKey,
            'description' => $this->description,
            'hasUsername' => $this->hasUsername,
            'hasPassword' => $this->hasPassword,
            'hasTotpSeed' => $this->hasTotpSeed,
        ];
    }
}

