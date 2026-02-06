<?php

namespace BrowserUseLaravel\Commands;

use Illuminate\Console\Command;
use BrowserUseLaravel\BrowserUseClient;

class BrowserUseCostCommand extends Command
{
    protected $signature = 'browseruse:cost {--task= : Task ID to check cost for} {--after= : Filter tasks after this date}';
    protected $description = 'Check Browser Use billing and task costs';

    public function handle(BrowserUseClient $browserUse): int
    {
        // Get account info
        $this->info('=== Browser Use Account ===');
        try {
            $account = $browserUse->billing()->getAccount();
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Credits Balance', '$' . number_format($account->totalCreditsBalanceUsd, 4)],
                    ['Monthly Credits', '$' . number_format($account->monthlyCreditsBalanceUsd ?? 0, 4)],
                    ['Additional Credits', '$' . number_format($account->additionalCreditsBalanceUsd ?? 0, 4)],
                    ['Rate Limit', $account->rateLimit ?? 'N/A'],
                    ['Plan', $account->planInfo->planName ?? 'N/A'],
                ]
            );
        } catch (\Exception $e) {
            $this->error('Failed to get account: ' . $e->getMessage());
        }

        // Cost info based on pricing page
        $this->newLine();
        $this->info('=== Cost Reference (Pay As You Go) ===');
        $this->table(
            ['Item', 'Cost'],
            [
                ['Agent Step', '$0.002 per step'],
                ['Browser Session', '$0.06 per hour'],
                ['Proxy Data', '$10 per GB'],
                ['Browser Use LLM', '~53 tasks per $1 (~$0.019/task)'],
            ]
        );

        // If task ID provided, get task details
        $taskId = $this->option('task');
        if ($taskId) {
            $this->newLine();
            $this->info('=== Task Details ===');
            try {
                $task = $browserUse->tasks()->get($taskId);
                $this->line("Task ID: {$task->id}");
                $this->line("Status: {$task->status}");
                $this->line("LLM: {$task->llm}");
                $this->line("Created: {$task->createdAt}");
                $this->line("Started: {$task->startedAt}");
                $this->line("Finished: {$task->finishedAt}");
                $this->line("Success: " . ($task->isSuccess ? 'Yes' : 'No'));
                
                // Calculate duration
                if ($task->startedAt && $task->finishedAt) {
                    $start = new \DateTime($task->startedAt);
                    $end = new \DateTime($task->finishedAt);
                    $diff = $start->diff($end);
                    $seconds = $diff->s + ($diff->i * 60) + ($diff->h * 3600);
                    $this->line("Duration: {$seconds} seconds");
                    
                    // Estimate session cost (hourly rate prorated)
                    $sessionCost = ($seconds / 3600) * 0.06;
                    $this->line("Est. Session Cost: \$" . number_format($sessionCost, 4));
                }
            } catch (\Exception $e) {
                $this->error('Failed to get task: ' . $e->getMessage());
            }
        }

        // Get recent tasks to see patterns
        $this->newLine();
        $this->info('=== Recent Tasks ===');
        try {
            $after = $this->option('after');
            $tasks = $browserUse->tasks()->list(
                pageSize: 10, 
                pageNumber: 1,
                after: $after
            );
            
            $rows = [];
            $totalCost = 0;
            foreach ($tasks->items as $task) {
                // Calculate duration
                $duration = '-';
                $estCost = 0;
                if ($task->startedAt && $task->finishedAt) {
                    $start = new \DateTime($task->startedAt);
                    $end = new \DateTime($task->finishedAt);
                    $diff = $start->diff($end);
                    $seconds = $diff->s + ($diff->i * 60) + ($diff->h * 3600);
                    $duration = "{$seconds}s";
                    $estCost = ($seconds / 3600) * 0.06;
                    $totalCost += $estCost;
                }
                
                $rows[] = [
                    substr($task->id, 0, 8) . '...',
                    $task->status,
                    $task->isSuccess ? '✓' : '✗',
                    $task->llm ?? '-',
                    $duration,
                    '$' . number_format($estCost, 4),
                ];
            }
            $this->table(['Task ID', 'Status', 'OK', 'LLM', 'Duration', 'Est. Session Cost'], $rows);
            $this->line("Total: {$tasks->totalItems} tasks");
            $this->line("Est. Total Session Cost (shown): \$" . number_format($totalCost, 4));
            $this->newLine();
            $this->warn("Note: This only shows session time cost. Actual cost includes:");
            $this->warn("  - Agent steps (~\$0.002 per step, ~10-30 steps per task)");
            $this->warn("  - LLM usage (varies by model, Browser Use LLM is cheapest)");
            $this->warn("  - Proxy data if used");
        } catch (\Exception $e) {
            $this->error('Failed to list tasks: ' . $e->getMessage());
        }

        return 0;
    }
}
