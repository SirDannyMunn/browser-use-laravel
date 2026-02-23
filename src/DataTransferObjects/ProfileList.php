<?php

namespace BrowserUseLaravel\DataTransferObjects;

class ProfileList
{
    /**
     * @param Profile[] $items
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
            fn(array $item) => Profile::fromArray($item),
            $payload['items'] ?? []
        );

        return new self(
            items: $items,
            totalItems: (int) ($payload['totalItems'] ?? 0),
            pageNumber: (int) ($payload['pageNumber'] ?? 1),
            pageSize: (int) ($payload['pageSize'] ?? 10),
        );
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(Profile $p) => $p->toArray(), $this->items),
            'totalItems' => $this->totalItems,
            'pageNumber' => $this->pageNumber,
            'pageSize' => $this->pageSize,
        ];
    }

    public function hasMore(): bool
    {
        return ($this->pageNumber * $this->pageSize) < $this->totalItems;
    }

    public function totalPages(): int
    {
        return (int) ceil($this->totalItems / $this->pageSize);
    }
}
