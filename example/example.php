<?php

namespace instantjay\crontasksphp;

chdir(__DIR__);
require_once('../vendor/autoload.php');

//
$task = function() {
    return 1+1;
};

$success = function() {
    echo "Success!\n";
};

$failure = function() {
    echo "Failure!\n";
};

$task = new CronTask($task, $success, $failure);

//
$repo = new CronTaskRepository();
$repo->addTask($task);

$result = $repo->execute();
$time = $result->totalExecutionTime() * 10000;
echo "$time seconds total.";