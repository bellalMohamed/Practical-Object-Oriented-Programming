<?php

use Todo\Models\Task as Task;
use Todo\Storage\MySqlDatabaseTaskStorage as MySqlDatabaseTaskStorage;
use Todo\TaskManager as TaskManager;

require_once 'vendor/autoload.php';

$db = new PDO('mysql:host=127.0.0.1;dbname=task_oop', 'root', '');
$manager = new TaskManager(new MySqlDatabaseTaskStorage($db));

// $task = $storage->get("3");
$task = new Task;
$task->setDescription('Learn More OOP last adds');
$task->setDue(new DateTime('+ 4 days'));
$task->setComplete(false);

var_dump($manager->addTask($task));
