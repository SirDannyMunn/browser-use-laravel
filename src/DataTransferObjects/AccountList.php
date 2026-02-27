<?php

namespace BrowserUseLaravel\DataTransferObjects;

class AccountList
{
    /**
     * @param Account[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems,
        public readonly int $pageNumber,
        public readonly int $pageSize,
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;

        $items = array_map(
            fn(array $item): Account => Account::fromArray($item),
            is_array($payload['items'] ?? null) ? $payload['items'] : []
        );

        return new self(
            items: $items,
            totalItems: (int) ($payload['totalItems'] ?? 0),
            pageNumber: (int) ($payload['pageNumber'] ?? 1),
            pageSize: (int) ($payload['pageSize'] ?? 25),
        );
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(Account $item) => $item->toArray(), $this->items),
            'totalItems' => $this->totalItems,
            'pageNumber' => $this->pageNumber,
            'pageSize' => $this->pageSize,
        ];
    }
}

