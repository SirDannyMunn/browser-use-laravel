<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Secret
{
    public function __construct(
        public readonly string $id,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $profileId,
        public readonly string $key,
        public readonly string $value,
        public readonly ?string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        return new self(
            id: (string) ($payload['id'] ?? ''),
            createdAt: (string) ($payload['createdAt'] ?? ''),
            updatedAt: (string) ($payload['updatedAt'] ?? ''),
            profileId: isset($payload['profileId']) ? (string) $payload['profileId'] : null,
            key: (string) ($payload['key'] ?? ''),
            value: (string) ($payload['value'] ?? ''),
            description: isset($payload['description']) ? (string) $payload['description'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'profileId' => $this->profileId,
            'key' => $this->key,
            'value' => $this->value,
            'description' => $this->description,
        ];
    }
}
