<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Profile
{
    public function __construct(
        public readonly string $id,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $name,
        public readonly ?string $lastUsedAt,
        public readonly array $cookieDomains,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        return new self(
            id: $payload['id'] ?? '',
            createdAt: $payload['createdAt'] ?? '',
            updatedAt: $payload['updatedAt'] ?? '',
            name: $payload['name'] ?? null,
            lastUsedAt: $payload['lastUsedAt'] ?? null,
            cookieDomains: $payload['cookieDomains'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'name' => $this->name,
            'lastUsedAt' => $this->lastUsedAt,
            'cookieDomains' => $this->cookieDomains,
        ];
    }
}
