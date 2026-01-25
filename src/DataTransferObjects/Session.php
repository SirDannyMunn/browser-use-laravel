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
        return new self(
            id: $data['id'] ?? '',
            status: $data['status'] ?? '',
            startedAt: $data['startedAt'] ?? '',
            liveUrl: $data['liveUrl'] ?? null,
            finishedAt: $data['finishedAt'] ?? null,
            publicShareUrl: $data['publicShareUrl'] ?? null,
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
        return $this->status === 'active';
    }

    public function isStopped(): bool
    {
        return $this->status === 'stopped';
    }
}
