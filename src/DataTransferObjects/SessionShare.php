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
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;
        $shareUrl = (string) ($payload['shareUrl'] ?? $payload['publicShareUrl'] ?? '');
        $shareToken = (string) ($payload['shareToken'] ?? '');

        if ($shareToken === '' && $shareUrl !== '') {
            $parts = parse_url($shareUrl);
            if (is_array($parts) && isset($parts['path'])) {
                $segments = array_values(array_filter(explode('/', $parts['path'])));
                $shareToken = (string) end($segments);
            }
        }

        return new self(
            shareToken: $shareToken,
            shareUrl: $shareUrl,
            viewCount: (int) ($payload['viewCount'] ?? 0),
            lastViewedAt: $payload['lastViewedAt'] ?? null,
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
