<?php
namespace Todo\Storage\Contracts;

use Todo\Models\Task;

interface TaskStorageInterface {
	// public function store(Task $task);
	public function store(Task $task);
	public function update(Task $task);
	public function get($id);
	public function all();
}