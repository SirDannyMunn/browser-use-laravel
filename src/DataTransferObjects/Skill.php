<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Skill
{
    /**
     * @param SkillParameter[] $parameters
     */
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly array $categories,
        public readonly array $domains,
        public readonly string $status,
        public readonly array $parameters,
        public readonly ?array $outputSchema,
        public readonly bool $isEnabled,
        public readonly bool $isPublic,
        public readonly int $currentVersion,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $slug,
        public readonly ?string $goal,
        public readonly ?string $agentPrompt,
        public readonly ?string $iconUrl,
        public readonly ?string $firstPublishedAt,
        public readonly ?string $lastPublishedAt,
        public readonly ?string $currentVersionStartedAt,
        public readonly ?string $currentVersionFinishedAt,
        public readonly ?string $code,
        public readonly ?string $clonedFromSkillId,
    ) {}

    public static function fromArray(array $data): self
    {
        $parameters = array_map(
            fn(array $param) => SkillParameter::fromArray($param),
            $data['parameters'] ?? []
        );

        return new self(
            id: $data['id'] ?? '',
            title: $data['title'] ?? '',
            description: $data['description'] ?? '',
            categories: $data['categories'] ?? [],
            domains: $data['domains'] ?? [],
            status: $data['status'] ?? '',
            parameters: $parameters,
            outputSchema: $data['outputSchema'] ?? null,
            isEnabled: (bool) ($data['isEnabled'] ?? false),
            isPublic: (bool) ($data['isPublic'] ?? false),
            currentVersion: (int) ($data['currentVersion'] ?? 1),
            createdAt: $data['createdAt'] ?? '',
            updatedAt: $data['updatedAt'] ?? '',
            slug: $data['slug'] ?? null,
            goal: $data['goal'] ?? null,
            agentPrompt: $data['agentPrompt'] ?? null,
            iconUrl: $data['iconUrl'] ?? null,
            firstPublishedAt: $data['firstPublishedAt'] ?? null,
            lastPublishedAt: $data['lastPublishedAt'] ?? null,
            currentVersionStartedAt: $data['currentVersionStartedAt'] ?? null,
            currentVersionFinishedAt: $data['currentVersionFinishedAt'] ?? null,
            code: $data['code'] ?? null,
            clonedFromSkillId: $data['clonedFromSkillId'] ?? null,
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
            'status' => $this->status,
            'parameters' => array_map(fn(SkillParameter $p) => $p->toArray(), $this->parameters),
            'outputSchema' => $this->outputSchema,
            'isEnabled' => $this->isEnabled,
            'isPublic' => $this->isPublic,
            'currentVersion' => $this->currentVersion,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'slug' => $this->slug,
            'goal' => $this->goal,
            'agentPrompt' => $this->agentPrompt,
            'iconUrl' => $this->iconUrl,
            'firstPublishedAt' => $this->firstPublishedAt,
            'lastPublishedAt' => $this->lastPublishedAt,
            'currentVersionStartedAt' => $this->currentVersionStartedAt,
            'currentVersionFinishedAt' => $this->currentVersionFinishedAt,
            'code' => $this->code,
            'clonedFromSkillId' => $this->clonedFromSkillId,
        ];
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isClone(): bool
    {
        return $this->clonedFromSkillId !== null;
    }
}
