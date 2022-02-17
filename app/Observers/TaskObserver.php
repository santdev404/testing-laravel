<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    
    public function created(Task $task)
    {
        $task->recordActivity('created_task');

    }

    public function updating(Task $task)
    {
        $task->old = $task->getOriginal();
    }

    public function deleted(Task $task)
    {
        $task->recordActivity('deleted_task');
        
    }

}
