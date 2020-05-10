<?php

namespace Tests\Infrastructure\UI\Laravel;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertDatabaseHasId($table, $id)
    {
        $em = app(EntityManagerInterface::class);

        $this->assertNotNull($em->find($table, $id));
    }
}
