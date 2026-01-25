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
        return new self(
            id: $data['id'] ?? '',
            sessionId: $data['sessionId'] ?? '',
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
