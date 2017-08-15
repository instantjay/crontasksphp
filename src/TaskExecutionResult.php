<?php

namespace instantjay\crontasksphp;

class TaskExecutionResult extends ExecutionResult {
    /**
     * @var $task CronTask
     */
    protected $task;

    /**
     * TaskExecutionResult constructor.
     * @param CronTask $task
     * @param bool $successful
     */
    public function __construct($task, $successful = true) {
        $this->task = $task;
        $this->successful = $successful;
    }

    public function executionTime() {
        return $this->task->executionTime();
    }
}