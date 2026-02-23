<?php

namespace BrowserUseLaravel\DataTransferObjects;

class CreateTaskResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $sessionId,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        return new self(
            id: $payload['id'] ?? '',
            sessionId: $payload['sessionId'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sessionId' => $this->sessionId,
        ];
    }
}
