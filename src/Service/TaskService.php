<?php

namespace App\Service;


use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use DateTimeImmutable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    /**
     * @throws NotFoundHttpException
     */
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

    public function updateById(int $id, UpdateTaskRequest $request): Task
    {
        $task = $this->getOrThrow($id);

        return $this->update($task, $request);
    }

    public function delete(Task $task): void
    {
        $this->repository->delete($task);
    }

    public function deleteById(int $id): void
    {
        $this->delete($this->getOrThrow($id));
    }
}
