<?php

namespace App\Tests\Feature\Service;

use App\Enum\Status;
use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use App\Tests\RefreshDatabaseTestCase;
use App\Service\TaskService;
use TypeError;

class TaskServiceTest extends RefreshDatabaseTestCase
{
    private TaskService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->getContainer()->get(TaskService::class);
    }

    public function testCanCreate()
    {
        $createDto = new CreateTaskRequest('title', 'desc');
        $newTask = $this->service->create($createDto);

        $taskFromDb = $this->service->getOrThrow($newTask->getId());
        self::assertEquals('title', $taskFromDb->getTitle());
        self::assertEquals('desc', $taskFromDb->getDescription());
        self::assertEquals(Status::New->value, $taskFromDb->getStatus());
    }

    public function testCanUpdate()
    {
        $createDto = new CreateTaskRequest('title', 'desc');
        $newTask = $this->service->create($createDto);

        $updateDto = new UpdateTaskRequest('title upd', 'desc upd', Status::InProgress);

        $updated = $this->service->update($newTask, $updateDto);
        self::assertEquals('title upd', $updated->getTitle());
        self::assertEquals('desc upd', $updated->getDescription());
        self::assertEquals(Status::InProgress->value, $updated->getStatus());
    }

    public function testCannotSetInvalidStatus()
    {
        self::expectException(TypeError::class);
        $createDto = new CreateTaskRequest('title', 'desc');
        $newTask = $this->service->create($createDto);

        $updateDto = new UpdateTaskRequest('title upd', 'desc upd', 'hello');

        $updated = $this->service->update($newTask, $updateDto);
        self::assertEquals('title upd', $updated->getTitle());
        self::assertEquals('desc upd', $updated->getDescription());
        self::assertEquals(Status::InProgress->value, $updated->getStatus());
    }
}
