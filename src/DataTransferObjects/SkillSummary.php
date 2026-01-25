<?php

namespace BrowserUseLaravel\DataTransferObjects;

class SkillSummary
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly array $categories,
        public readonly array $domains,
        public readonly bool $isPublic,
        public readonly int $currentVersion,
        public readonly string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            title: $data['title'] ?? '',
            description: $data['description'] ?? '',
            categories: $data['categories'] ?? [],
            domains: $data['domains'] ?? [],
            isPublic: (bool) ($data['isPublic'] ?? false),
            currentVersion: (int) ($data['currentVersion'] ?? 1),
            status: $data['status'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'categories' => $this->categories,
            'domains' => $this->domains,
            'isPublic' => $this->isPublic,
            'currentVersion' => $this->currentVersion,
            'status' => $this->status,
        ];
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isProcessing(): bool
    {
        return in_array($this->status, ['recording', 'processing']);
    }

    public function hasError(): bool
    {
        return $this->status === 'error';
    }
}
