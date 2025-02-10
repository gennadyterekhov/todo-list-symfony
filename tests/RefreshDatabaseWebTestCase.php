<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshDatabaseWebTestCase extends WebTestCase
{
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        self::createClient();

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        RefreshDatabase::clearDb($this->entityManager);
    }
}
