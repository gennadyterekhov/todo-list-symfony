<?php

namespace App\Controller;

use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    public function __construct(private TaskService $service, private SerializerInterface $serializer)
    {
    }

    #[Route('/api/tasks', methods: ['GET', 'HEAD'])]
    public function list(): JsonResponse
    {
        return $this->json($this->service->list());
    }

    #[Route('/api/tasks/{id}', methods: ['GET', 'HEAD'])]
    public function get(int $id): JsonResponse
    {
        return $this->json($this->service->getOrThrow($id));
    }

    #[Route('/api/tasks', methods: ['POST', 'HEAD'])]
    public function create(Request $request): JsonResponse
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $createTaskRequest = $this->serializer->deserialize($request->getContent(), CreateTaskRequest::class, 'json');

        $task = $this->service->create($createTaskRequest);
        return $this->json($task,201);
    }

    #[Route('/api/tasks/{id}', methods: ['PUT', 'HEAD'])]
    public function update(int $id, Request $request): JsonResponse
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $updateTaskRequest = $this->serializer->deserialize($request->getContent(), UpdateTaskRequest::class, 'json');
        $task = $this->service->updateById($id, $updateTaskRequest);
        return $this->json($task);
    }

    #[Route('/api/tasks/{id}', methods: ['DELETE', 'HEAD'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteById($id);

        return new JsonResponse([], 204);
    }
}
