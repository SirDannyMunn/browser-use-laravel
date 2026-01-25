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
        return new self(
            id: $data['id'] ?? '',
            createdAt: $data['createdAt'] ?? '',
            updatedAt: $data['updatedAt'] ?? '',
            name: $data['name'] ?? null,
            lastUsedAt: $data['lastUsedAt'] ?? null,
            cookieDomains: $data['cookieDomains'] ?? [],
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
