<?php

namespace App\Service;


use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use DateTimeImmutable;

final class TaskService
{
    public function __construct(private TaskRepository $repository)
    {
    }

    public function create(CreateTaskRequest $request): Task
    {
        $task = (new Task())
            ->setTitle($request->getTitle())
            ->setDescription($request->getDescription());
        $this->repository->create($task);
        return $task;
    }

    public function getOrThrow(int $id): Task
    {
        return $this->repository->getOrThrow($id);
    }

    /**
     * @return Task[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function update(Task $task, UpdateTaskRequest $request): Task
    {
        $task->setTitle($request->getTitle())
            ->setDescription($request->getDescription())
            ->setStatus($request->getStatus()->value)
            ->setUpdatedAt(new DateTimeImmutable());
        $this->repository->update($task);
        return $task;
    }

    public function delete(Task $task): void
    {
        $this->repository->delete($task);
    }
}
