<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Session
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $startedAt,
        public readonly ?string $liveUrl,
        public readonly ?string $finishedAt,
        public readonly ?string $publicShareUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        return new self(
            id: $payload['id'] ?? '',
            status: $payload['status'] ?? '',
            startedAt: $payload['startedAt'] ?? '',
            liveUrl: $payload['liveUrl'] ?? null,
            finishedAt: $payload['finishedAt'] ?? null,
            publicShareUrl: $payload['publicShareUrl'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'startedAt' => $this->startedAt,
            'liveUrl' => $this->liveUrl,
            'finishedAt' => $this->finishedAt,
            'publicShareUrl' => $this->publicShareUrl,
        ];
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'ready'], true);
    }

    public function isStopped(): bool
    {
        return $this->status === 'stopped';
    }
}
