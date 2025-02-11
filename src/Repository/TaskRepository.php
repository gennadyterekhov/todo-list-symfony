<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function create(Task $task): Task
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
        return $task;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getOrThrow(int $id): Task
    {
        $task = $this->findById($id);
        if (!$task) {
            throw new NotFoundHttpException('task not found. id: ' . $id);
        }

        return $task;
    }

    public function findById(int $id): ?Task
    {
        return $this->find($id);
    }

    public function update(Task $task): void
    {
        $this->getEntityManager()->flush();
    }

    public function delete(Task $task): void
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }
}
