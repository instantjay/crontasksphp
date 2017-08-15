<?php

namespace instantjay\crontasksphp;

use Monolog\Logger;

class CronTask {
    protected $callable;
    protected $successCallable;
    protected $failureCallable;

    protected $executed;
    protected $startTime;
    protected $endTime;
    protected $duration;

    protected $logger;

    /**
     * CronTask constructor.
     * @param $callable callable
     * @param $successCallable callable
     * @param $failureCallable callable
     */
    public function __construct($callable, $successCallable, $failureCallable) {
        $this->callable = $callable;
        $this->successCallable = $successCallable;
        $this->failureCallable = $failureCallable;

        $this->executed = false;
    }

    /**
     * @param $logger Logger
     */
    public function bindLogger($logger) {
        $this->logger = $logger;
    }

    /**
     * @throws \Exception
     */
    public function execute() {
        if($this->executed)
            throw new \Exception('This task was already executed once.');

        $this->startTimer();
        $this->executed = true;

        try {
            $callable = $this->callable;
            $callable($this->logger);

            $this->succeeded();
        }
        catch(\Exception $e) {
            $this->failed($e);
        }

        return new TaskExecutionResult($this);
    }

    protected function succeeded() {
        $callable = $this->successCallable;
        $callable($this->logger);

        $this->stopTimer();
    }

    protected function failed(\Exception $e) {
        $callable = $this->failureCallable;
        $callable($this->logger);

        $this->stopTimer();
    }

    protected function reset() {
        $this->executed = false;
        $this->startTime = null;
        $this->endTime = null;
        $this->duration = null;
    }

    private function startTimer() {
        $this->startTime = microtime(true);
    }

    /**
     * @throws \Exception
     */
    private function stopTimer() {
        if(!$this->startTime)
            throw new \Exception('Task end time cannot be calculated because task was never started.');

        $this->endTime = microtime(true);
        $this->duration = $this->endTime - $this->startTime;
    }

    public function executionTime() {
        if(!$this->executed)
            throw new \Exception('Task not yet executed.');

        return $this->duration;
    }
}