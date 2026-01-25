<?php

namespace BrowserUseLaravel\DataTransferObjects;

class PresignedUrl
{
    public function __construct(
        public readonly string $url,
        public readonly string $method,
        public readonly array $fields,
        public readonly string $fileName,
        public readonly int $expiresIn,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['url'] ?? '',
            method: $data['method'] ?? 'POST',
            fields: $data['fields'] ?? [],
            fileName: $data['fileName'] ?? '',
            expiresIn: (int) ($data['expiresIn'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'method' => $this->method,
            'fields' => $this->fields,
            'fileName' => $this->fileName,
            'expiresIn' => $this->expiresIn,
        ];
    }
}
