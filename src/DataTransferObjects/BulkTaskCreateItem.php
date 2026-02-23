<?php

namespace BrowserUseLaravel\DataTransferObjects;

class BulkTaskCreateItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly ?int $executionOrder,
        public readonly ?string $completionWebhookStatus,
        public readonly ?array $metadata = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) ($data['id'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            executionOrder: isset($data['executionOrder']) ? (int) $data['executionOrder'] : null,
            completionWebhookStatus: isset($data['completionWebhookStatus']) ? (string) $data['completionWebhookStatus'] : null,
            metadata: is_array($data['metadata'] ?? null) ? $data['metadata'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'executionOrder' => $this->executionOrder,
            'completionWebhookStatus' => $this->completionWebhookStatus,
            'metadata' => $this->metadata,
        ];
    }
}
