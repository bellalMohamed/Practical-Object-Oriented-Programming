<?php
namespace Todo;
use Todo\Storage\Contracts\TaskStorageInterface as TaskStorageInterface;
use Todo\Models\Task as Task;

class TaskManager
{
	protected $storage;

	public function __construct(TaskStorageInterface $storage)
	{
		$this->storage = $storage;
	}

	public function addTask(Task $task)
	{
		return $this->storage->store($task);
	}

	public function updateTask(Task $task)
	{
		return $this->storage->update($task);
	}

	public function getTask($id)
	{
		return $this->storage->get($id); 
	}

	public function getTasks()
	{
		return $this->storage->all();
	}




}

