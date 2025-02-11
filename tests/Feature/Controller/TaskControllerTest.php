<?php

namespace Feature\Controller;

use App\Enum\Status;
use App\Request\CreateTaskRequest;
use App\Service\TaskService;
use App\Tests\RefreshDatabaseWebTestCase;

class TaskControllerTest extends RefreshDatabaseWebTestCase
{
    public function testCanCreate()
    {
        $this->getClient()->jsonRequest('POST', '/api/tasks', ['title' => 'title', 'description' => 'desc']);
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->getClient()->getResponse()->getContent(), true);
        self::assertEquals('title', $response['title']);
        self::assertEquals('desc', $response['description']);
        self::assertEquals(Status::New->value, $response['status']);
    }

    public function testCanGetList()
    {
        $this->createSeveralTasks();

        $this->getClient()->jsonRequest('GET', '/api/tasks');
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->getClient()->getResponse()->getContent(), true);
        self::assertCount(5, $response);

        $task = $response[0];
        self::assertTrue(str_starts_with($task['title'], 'title'));
        self::assertTrue(str_starts_with($task['description'], 'desc'));
        self::assertEquals(Status::New->value, $task['status']);
        self::assertArrayHasKey('createdAt', $task);
        self::assertArrayHasKey('updatedAt', $task);
    }

    public function testCanGetOne()
    {
        $tasks = $this->createSeveralTasks();

        $this->getClient()->jsonRequest('GET', '/api/tasks/' . $tasks[0]->getId());
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->getClient()->getResponse()->getContent(), true);

        self::assertEquals('title 1', $response['title']);
        self::assertArrayHasKey('description', $response);
        self::assertArrayHasKey('status', $response);
        self::assertArrayHasKey('createdAt', $response);
        self::assertArrayHasKey('updatedAt', $response);
    }

    public function testCanUpdate()
    {
        $service = $this->getContainer()->get(TaskService::class);
        $task = $service->create(new CreateTaskRequest('title 1', 'desc'));

        $this->getClient()->jsonRequest(
            'PUT',
            '/api/tasks/' . $task->getId(),
            ['title' => 'title upd', 'description' => 'desc upd', 'status' => Status::Done->value]
        );
        $this->assertResponseIsSuccessful();

        $response = json_decode($this->getClient()->getResponse()->getContent(), true);
        self::assertTrue(str_starts_with($response['title'], 'title upd'));
        self::assertTrue(str_starts_with($response['description'], 'desc upd'));
        self::assertEquals(Status::Done->value, $response['status']);
    }

    public function testCanDelete()
    {
        $tasks = $this->createSeveralTasks();

        $this->getClient()->jsonRequest('DELETE', '/api/tasks/' . $tasks[0]->getId());
        $this->assertResponseIsSuccessful();

        $this->getClient()->jsonRequest('GET', '/api/tasks');
        $this->assertResponseIsSuccessful();
        $response = json_decode($this->getClient()->getResponse()->getContent(), true);
        self::assertCount(4, $response);
    }

    public function testErrorInJson()
    {
        $this->getClient()->jsonRequest('GET', '/api/tasks/1');
        $this->assertResponseStatusCodeSame(404);

        $response = json_decode($this->getClient()->getResponse()->getContent(), true);
        self::assertIsArray($response);
        self::assertArrayHasKey('message', $response);
    }

    public function createSeveralTasks(): array
    {
        $service = $this->getContainer()->get(TaskService::class);

        $tasks = [];
        $tasks[] = $service->create(new CreateTaskRequest('title 1', 'desc'));
        $tasks[] = $service->create(new CreateTaskRequest('title 2', 'desc'));
        $tasks[] = $service->create(new CreateTaskRequest('title 3', 'desc'));
        $tasks[] = $service->create(new CreateTaskRequest('title 4', 'desc'));
        $tasks[] = $service->create(new CreateTaskRequest('title 5', 'desc'));
        return $tasks;
    }
}

