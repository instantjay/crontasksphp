<?php

namespace instantjay\crontasksphp;

class RepositoryExecutionResult extends ExecutionResult {
    /**
     * @var $results TaskExecutionResult[]
     */
    private $results;

    /**
     * RepositoryExecutionResult constructor.
     * @param $cronTaskResults TaskExecutionResult[]
     */
    public function __construct($cronTaskResults) {
        $this->results = $cronTaskResults;
    }

    public function totalExecutionTime() {
        $totalTime = 0;

        foreach($this->results as $r) {
            $totalTime += $r->executionTime();
        }

        return $totalTime;
    }
}