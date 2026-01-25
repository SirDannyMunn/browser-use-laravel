<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Task;
use BrowserUseLaravel\DataTransferObjects\TaskList;
use BrowserUseLaravel\DataTransferObjects\CreateTaskResponse;

class TasksResource extends Resource
{
    /**
     * Get paginated list of AI agent tasks with optional filtering.
     *
     * GET /tasks
     *
     * @param int $pageSize Number of items per page (1-100, default 10)
     * @param int $pageNumber Page number (1-based, default 1)
     * @param string|null $sessionId Filter by session ID (UUID)
     * @param string|null $filterBy Filter by status: created, started, finished, stopped
     * @param string|null $after Filter tasks after this datetime (ISO 8601)
     * @param string|null $before Filter tasks before this datetime (ISO 8601)
     */
    public function list(
        int $pageSize = 10,
        int $pageNumber = 1,
        ?string $sessionId = null,
        ?string $filterBy = null,
        ?string $after = null,
        ?string $before = null,
    ): TaskList {
        $query = array_filter([
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
            'sessionId' => $sessionId,
            'filterBy' => $filterBy,
            'after' => $after,
            'before' => $before,
        ], fn($v) => $v !== null);

        $response = $this->http->get('/tasks', $query);
        return TaskList::fromArray($response);
    }

    /**
     * Start a new task in an existing session, or create a new session to run the task.
     *
     * POST /tasks
     *
     * @param string $task The task prompt/instruction for the agent
     * @param string|null $llm The LLM model to use (e.g., gpt-4, claude-2)
     * @param string|null $startUrl The URL to start the task from
     * @param int $maxSteps Maximum number of steps (1-10000, default 30)
     * @param string|null $structuredOutput Stringified JSON schema for structured output
     * @param string|null $sessionId ID of an existing session to run the task in
     * @param array|null $metadata Up to 10 key-value metadata pairs
     * @param array|null $secrets Secrets for the task (e.g., credentials)
     * @param array|null $allowedDomains List of allowed domains
     * @param string|null $opVaultId 1Password vault ID for injecting secrets
     * @param bool $highlightElements Whether to highlight elements
     * @param bool $flashMode Whether to enable flash mode
     * @param bool $thinking Whether to enable thinking mode
     * @param bool|string $vision Enable vision (true, false, or 'auto')
     * @param string $systemPromptExtension Extension to the agent system prompt
     * @param bool $judge Enable judge mode for task completion evaluation
     * @param string|null $judgeGroundTruth Ground truth for judging
     * @param string|null $judgeLlm LLM model to use for judging
     * @param array|null $skillIds List of skill IDs to enable (use ['*'] for all)
     */
    public function create(
        string $task,
        ?string $llm = null,
        ?string $startUrl = null,
        int $maxSteps = 30,
        ?string $structuredOutput = null,
        ?string $sessionId = null,
        ?array $metadata = null,
        ?array $secrets = null,
        ?array $allowedDomains = null,
        ?string $opVaultId = null,
        bool $highlightElements = false,
        bool $flashMode = false,
        bool $thinking = false,
        bool|string $vision = false,
        string $systemPromptExtension = '',
        bool $judge = false,
        ?string $judgeGroundTruth = null,
        ?string $judgeLlm = null,
        ?array $skillIds = null,
    ): CreateTaskResponse {
        $data = array_filter([
            'task' => $task,
            'llm' => $llm,
            'startUrl' => $startUrl,
            'maxSteps' => $maxSteps,
            'structuredOutput' => $structuredOutput,
            'sessionId' => $sessionId,
            'metadata' => $metadata,
            'secrets' => $secrets,
            'allowedDomains' => $allowedDomains,
            'opVaultId' => $opVaultId,
            'highlightElements' => $highlightElements,
            'flashMode' => $flashMode,
            'thinking' => $thinking,
            'vision' => $vision,
            'systemPromptExtension' => $systemPromptExtension !== '' ? $systemPromptExtension : null,
            'judge' => $judge,
            'judgeGroundTruth' => $judgeGroundTruth,
            'judgeLlm' => $judgeLlm,
            'skillIds' => $skillIds,
        ], fn($v) => $v !== null && $v !== false);

        // Ensure required field is present
        $data['task'] = $task;

        $response = $this->http->post('/tasks', $data);
        return CreateTaskResponse::fromArray($response);
    }

    /**
     * Get detailed information about a specific task.
     *
     * GET /tasks/{task_id}
     *
     * @param string $taskId The task ID (UUID)
     */
    public function get(string $taskId): Task
    {
        $response = $this->http->get("/tasks/{$taskId}");
        return Task::fromArray($response);
    }

    /**
     * Stop or modify an ongoing task.
     *
     * PATCH /tasks/{task_id}
     *
     * @param string $taskId The task ID (UUID)
     * @param string $action The action to perform: 'stop' or 'stop_task_and_session'
     */
    public function update(string $taskId, string $action): Task
    {
        $response = $this->http->patch("/tasks/{$taskId}", [
            'action' => $action,
        ]);
        return Task::fromArray($response);
    }

    /**
     * Stop a running task.
     *
     * @param string $taskId The task ID (UUID)
     */
    public function stop(string $taskId): Task
    {
        return $this->update($taskId, 'stop');
    }

    /**
     * Stop a running task and its session.
     *
     * @param string $taskId The task ID (UUID)
     */
    public function stopWithSession(string $taskId): Task
    {
        return $this->update($taskId, 'stop_task_and_session');
    }

    /**
     * Retrieve the logs for a specific task execution.
     *
     * GET /tasks/{task_id}/logs
     *
     * @param string $taskId The task ID (UUID)
     */
    public function getLogs(string $taskId): string
    {
        return $this->http->getRaw("/tasks/{$taskId}/logs");
    }
}
