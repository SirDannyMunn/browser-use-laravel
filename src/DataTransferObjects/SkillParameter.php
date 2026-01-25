<?php

namespace BrowserUseLaravel\DataTransferObjects;

class SkillParameter
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly bool $required,
        public readonly ?string $description,
        public readonly ?string $cookieDomain,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? '',
            type: $data['type'] ?? 'string',
            required: (bool) ($data['required'] ?? false),
            description: $data['description'] ?? null,
            cookieDomain: $data['cookieDomain'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
            'description' => $this->description,
            'cookieDomain' => $this->cookieDomain,
        ];
    }
}
