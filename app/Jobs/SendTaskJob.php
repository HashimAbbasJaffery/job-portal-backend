<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\DispatchMessage;
use App\Events\NotificationEvent;

class SendTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $user_id;
    public $deadline;
    public $task_id;
    public function __construct($user_id, $deadline, $task_id)
    {
        $this->user_id = $user_id;
        $this->deadline = $deadline;
        $this->task_id = $task_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new NotificationEvent(auth()->user()->id, $this->user_id, "New Task", "new_task"));
        event(new DispatchMessage(
                "You have recieved new task", 
                auth()->user()->id, $this->user_id, 
                "new_task", 
                $this->deadline,
                $this->task_id
            )
        );
    }
}
