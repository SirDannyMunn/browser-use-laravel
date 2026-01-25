<?php

namespace BrowserUseLaravel\DataTransferObjects;

class SessionShare
{
    public function __construct(
        public readonly string $shareToken,
        public readonly string $shareUrl,
        public readonly int $viewCount,
        public readonly ?string $lastViewedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            shareToken: $data['shareToken'] ?? '',
            shareUrl: $data['shareUrl'] ?? '',
            viewCount: (int) ($data['viewCount'] ?? 0),
            lastViewedAt: $data['lastViewedAt'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'shareToken' => $this->shareToken,
            'shareUrl' => $this->shareUrl,
            'viewCount' => $this->viewCount,
            'lastViewedAt' => $this->lastViewedAt,
        ];
    }
}
