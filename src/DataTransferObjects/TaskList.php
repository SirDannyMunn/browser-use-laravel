<?php

namespace BrowserUseLaravel\DataTransferObjects;

class TaskList
{
    /**
     * @param Task[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems,
        public readonly int $pageNumber,
        public readonly int $pageSize,
    ) {}

    public static function fromArray(array $data): self
    {
        $items = array_map(
            fn(array $item) => Task::fromArray($item),
            $data['items'] ?? []
        );

        return new self(
            items: $items,
            totalItems: (int) ($data['totalItems'] ?? 0),
            pageNumber: (int) ($data['pageNumber'] ?? 1),
            pageSize: (int) ($data['pageSize'] ?? 10),
        );
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(Task $t) => $t->toArray(), $this->items),
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
