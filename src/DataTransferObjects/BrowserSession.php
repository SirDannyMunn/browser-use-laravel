<?php

namespace BrowserUseLaravel\DataTransferObjects;

class BrowserSession
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $timeoutAt,
        public readonly string $startedAt,
        public readonly ?string $liveUrl,
        public readonly ?string $cdpUrl,
        public readonly ?string $finishedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            status: $data['status'] ?? '',
            timeoutAt: $data['timeoutAt'] ?? '',
            startedAt: $data['startedAt'] ?? '',
            liveUrl: $data['liveUrl'] ?? null,
            cdpUrl: $data['cdpUrl'] ?? null,
            finishedAt: $data['finishedAt'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'timeoutAt' => $this->timeoutAt,
            'startedAt' => $this->startedAt,
            'liveUrl' => $this->liveUrl,
            'cdpUrl' => $this->cdpUrl,
            'finishedAt' => $this->finishedAt,
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
