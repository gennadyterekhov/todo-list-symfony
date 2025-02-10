<?php

namespace App\Tests\Feature\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Tests\RefreshDatabaseTestCase;

class TaskRepositoryTest extends RefreshDatabaseTestCase
{
    private TaskRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->entityManager->getRepository(Task::class);
    }

    public function testCanGetTasksCount()
    {
        $count = $this->repository->count();
        self::assertEquals(0, $count);
    }

    public function testCanGetTaskById()
    {
        $task1 = (new Task())->setTitle('test');
        $this->entityManager->persist($task1);
        $this->entityManager->flush();

        /** @var Task $task1 */
        $task1 = $this->repository->find(1);
        self::assertEquals('test', $task1->getTitle());
    }

    public function testCanDeleteTask()
    {
        $task1 = new Task();
        $this->entityManager->persist($task1);
        $this->entityManager->flush();

        $count = $this->repository->count();
        self::assertEquals(1, $count);

        $this->repository->delete($task1);
        $this->entityManager->flush();

        $count = $this->repository->count();
        self::assertEquals(0, $count);
    }
}
