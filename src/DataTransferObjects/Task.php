<?php

namespace BrowserUseLaravel\DataTransferObjects;

class Task
{
    public function __construct(
        public readonly string $id,
        public readonly string $sessionId,
        public readonly ?string $llm,
        public readonly string $task,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly ?string $startedAt,
        public readonly ?string $finishedAt,
        public readonly ?array $metadata,
        public readonly ?string $output,
        public readonly ?string $browserUseVersion,
        public readonly ?bool $isSuccess,
        public readonly ?string $judgement,
        public readonly ?bool $judgeVerdict,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            sessionId: $data['sessionId'] ?? '',
            llm: $data['llm'] ?? null,
            task: $data['task'] ?? '',
            status: $data['status'] ?? '',
            createdAt: $data['createdAt'] ?? '',
            startedAt: $data['startedAt'] ?? null,
            finishedAt: $data['finishedAt'] ?? null,
            metadata: $data['metadata'] ?? null,
            output: $data['output'] ?? null,
            browserUseVersion: $data['browserUseVersion'] ?? null,
            isSuccess: $data['isSuccess'] ?? null,
            judgement: $data['judgement'] ?? null,
            judgeVerdict: $data['judgeVerdict'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sessionId' => $this->sessionId,
            'llm' => $this->llm,
            'task' => $this->task,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'startedAt' => $this->startedAt,
            'finishedAt' => $this->finishedAt,
            'metadata' => $this->metadata,
            'output' => $this->output,
            'browserUseVersion' => $this->browserUseVersion,
            'isSuccess' => $this->isSuccess,
            'judgement' => $this->judgement,
            'judgeVerdict' => $this->judgeVerdict,
        ];
    }

    public function isRunning(): bool
    {
        return in_array($this->status, ['created', 'started']);
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['finished', 'stopped']);
    }
}
