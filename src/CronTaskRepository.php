<?php

namespace instantjay\crontasksphp;

use Monolog\Logger;

class CronTaskRepository {
    /**
     * @var $logger Logger
     */
    private $logger;

    /**
     * @var $tasks CronTask[]
     */
    private $tasks;

    /**
     * CronTaskRepository constructor.
     * @param $logger Logger
     */
    public function __construct($logger = null) {
        if($logger == null)
            $logger = new Logger('null_logger');

        $this->logger = $logger;
    }

    /**
     * @returns RepositoryExecutionResult
     */
    public function execute() {
        $results = [];

        foreach($this->tasks as $t) {
            $t->bindLogger($this->logger);

            $results[] = $t->execute();
        }

        $result = new RepositoryExecutionResult($results);
        return $result;
    }

    /**
     * @param $task CronTask
     */
    public function addTask($task) {
        $this->tasks[] = $task;
    }
}