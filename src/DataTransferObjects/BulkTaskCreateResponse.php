<?php

namespace BrowserUseLaravel\DataTransferObjects;

class BulkTaskCreateResponse
{
    /**
     * @param array<int, BulkTaskCreateItem> $data
     */
    public function __construct(
        public readonly string $batchId,
        public readonly ?string $sessionId,
        public readonly int $submittedCount,
        public readonly array $data,
    ) {}

    public static function fromArray(array $payload): self
    {
        $items = [];
        foreach ((array) ($payload['data'] ?? []) as $row) {
            if (!is_array($row)) {
                continue;
            }
            $items[] = BulkTaskCreateItem::fromArray($row);
        }

        return new self(
            batchId: (string) ($payload['batchId'] ?? ''),
            sessionId: is_string($payload['sessionId'] ?? null) ? (string) $payload['sessionId'] : null,
            submittedCount: (int) ($payload['submittedCount'] ?? count($items)),
            data: $items,
        );
    }

    public function toArray(): array
    {
        return [
            'batchId' => $this->batchId,
            'sessionId' => $this->sessionId,
            'submittedCount' => $this->submittedCount,
            'data' => array_map(
                static fn(BulkTaskCreateItem $item) => $item->toArray(),
                $this->data,
            ),
        ];
    }
}
