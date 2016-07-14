<?php
namespace Todo\Storage;

use Todo\Models\Task;
use Todo\Storage\Contracts\TaskStorageInterface;
use PDO;

class MySqlDatabaseTaskStorage implements TaskStorageInterface
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function store(Task $task)
	{
		$statement = $this->db->prepare("
			INSERT INTO tasks (description, due, complete)
			VALUES (:description, :due, :complete) 
		"); 
		$statement->execute($this->buildColumns($task));

		return $this->get($this->db->lastInsertId());
	}

	public function update(Task $task)
	{
		$statement = $this->db->prepare("
			UPDATE tasks 
			SET
				description = :description,
				due = :due,
				complete = :complete
			WHERE 
				id = :id
		");

		$statement->execute($this->buildColumns($task,[
			'id' => $task->getId()
		]));

		return $this->get($task->getId());
	}

	public function get($id)
	{
		$statement = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");

		$statement->setFetchMode(PDO::FETCH_CLASS, Task::class);

		$statement->execute([
			'id' => $id,
		]);

		return $statement->fetch();
	}

	public function all()
	{
		$statement = $this->db->prepare("SELECT * FROM tasks");
		$statement->setFetchMode(PDO::FETCH_CLASS, Task::class);
		$statement->execute();
		return $statement->fetchAll();
	}

	public function buildColumns(Task $task, array $additional = [])
	{
		return array_merge([
			'description' => $task->getDescription(),
			'due'		  => $task->getDue()->format("Y-m-d H:i:s"),
			'complete'	  => $task->getComplete(),
		], $additional);
	}




} 
