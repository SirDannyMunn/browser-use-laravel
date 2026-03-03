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
        /** @var array<int,array<string,mixed>> */
        public readonly array $outputFiles = [],
    ) {}

    public static function fromArray(array $data): self
    {
        $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;
        $error = is_array($payload['error'] ?? null) ? $payload['error'] : null;

        return new self(
            id: $payload['id'] ?? '',
            sessionId: $payload['sessionId'] ?? '',
            llm: $payload['llm'] ?? null,
            task: $payload['task'] ?? '',
            status: $payload['status'] ?? '',
            createdAt: $payload['createdAt'] ?? '',
            startedAt: $payload['startedAt'] ?? null,
            finishedAt: $payload['finishedAt'] ?? null,
            metadata: $payload['metadata'] ?? null,
            output: $payload['output'] ?? $payload['outputText'] ?? ($error['message'] ?? null),
            browserUseVersion: $payload['browserUseVersion'] ?? null,
            isSuccess: $payload['isSuccess'] ?? null,
            judgement: $payload['judgement'] ?? null,
            judgeVerdict: $payload['judgeVerdict'] ?? null,
            outputFiles: is_array($payload['outputFiles'] ?? null)
                ? $payload['outputFiles']
                : (is_array($payload['output_files'] ?? null) ? $payload['output_files'] : []),
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
            'outputFiles' => $this->outputFiles,
        ];
    }

    public function isRunning(): bool
    {
        return in_array($this->status, ['created', 'started']);
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['finished', 'stopped', 'cancelled', 'failed', 'blocked', 'succeeded'], true);
    }
}
