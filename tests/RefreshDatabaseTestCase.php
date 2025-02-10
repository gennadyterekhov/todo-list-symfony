<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RefreshDatabaseTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->clearDb($this->entityManager);
    }

    private function clearDb(EntityManagerInterface $entityManager)
    {
        $connection = $entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();

        $tables = $schemaManager->listTables();

        foreach ($tables as $table) {
            $connection->executeQuery("TRUNCATE TABLE {$table->getName()}");
        }
    }
}
