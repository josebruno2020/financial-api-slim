<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Adapters;

use App\Infrastructure\Adapters\PasswordPhpAdapter;
use Tests\TestCase;

class PasswordPhpAdapterTest extends TestCase
{
    public function testSetPassword()
    {
        $adapter = new PasswordPhpAdapter();
        $rawPassword = '123123';
        $password = $adapter->setPassword($rawPassword);

        $this->assertIsString($password);
        $this->assertNotEquals($password, $rawPassword);
    }

    public function testVerifyPassword()
    {
        $adapter = new PasswordPhpAdapter();
        $rawPassword = '123123';
        $password = $adapter->setPassword($rawPassword);

        $this->assertTrue(
            $adapter->verifyPassword($rawPassword, $password)
        );
        $this->assertFalse(
            $adapter->verifyPassword('123122', $password)
        );
    }
}