<?php

namespace App\Tests;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class RefreshDatabase
{
    /**
     * @throws Exception
     */
    public static function clearDb(EntityManagerInterface $entityManager)
    {
        $connection = $entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();

        $tables = $schemaManager->listTables();

        foreach ($tables as $table) {
            $connection->executeQuery("TRUNCATE TABLE {$table->getName()}");
        }
    }
}
