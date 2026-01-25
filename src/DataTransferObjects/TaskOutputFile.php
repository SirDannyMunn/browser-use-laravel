<?php

namespace BrowserUseLaravel\DataTransferObjects;

class TaskOutputFile
{
    public function __construct(
        public readonly string $id,
        public readonly string $fileName,
        public readonly string $downloadUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            fileName: $data['fileName'] ?? '',
            downloadUrl: $data['downloadUrl'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fileName' => $this->fileName,
            'downloadUrl' => $this->downloadUrl,
        ];
    }
}
