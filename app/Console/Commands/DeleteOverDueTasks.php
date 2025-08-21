<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class DeleteOverDueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-over-due-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks older than 30 days and log the deletions compactly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateThreshold = now()->subDays(30);

        // Fetch tasks older than 30 days
        $tasks = Task::where('created_at', '<', $dateThreshold)->get();

        if ($tasks->isEmpty()) {
            $this->info('No tasks older than 30 days found.');
            return;
        }

        // Collect task info for logging
        $deletedTasks = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
            ];
        })->toArray();

        // Bulk delete
        Task::whereIn('id', $tasks->pluck('id'))->delete();

        // Log all deletions in one entry
        Log::channel('task_deletions')->info('Deleted tasks older than 30 days', [
            'deleted_count' => count($deletedTasks),
            'tasks' => $deletedTasks,
            'deleted_at' => now()->toDateTimeString(),
        ]);

        $this->info("Deleted {$tasks->count()} tasks older than 30 days.");
    }
}
