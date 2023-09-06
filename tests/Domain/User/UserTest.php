<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider(): array
    {
        return [
            ['email1@test.com', 'Teste', 'oasdoaosd', 1],
            ['email2@test.com', 'Teste 2', 'oasdoaosd', 2],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int $id
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function testGetters(string $email, string $name, string $password, int $id)
    {
        $user = new User($email, $name, $password, $id);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($password, $user->getPassword());
    }

    /**
     * @dataProvider userProvider
     * @param int $id
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function testJsonSerialize(string $email, string $name, string $password, int $id)
    {
        $user = new User($email, $name, $password, $id);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'email' => $email
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
