<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Memory\User\InMemoryUserRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new User('email@teste.com', 'Teste', '123123', 1),
        ];

        $userRepository = new InMemoryUserRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }

    public function testCreateUser()
    {
        $userRepository = new InMemoryUserRepository([]);

        $data = [
            'email' => 'email@teste.com',
            'name' => 'Teste',
            'password' => '123123'
        ];

        $userRepository->createUser($data);

        $this->assertCount(1, $userRepository->findAll());
    }

    public function testUpdateUser()
    {
        $user = $this->userMock();
        $userRepository = new InMemoryUserRepository([1 => $user]);

        $data = [
            'id' => 1,
            'email' => 'email@teste.com',
            'name' => 'Teste',
        ];

        $userRepository->updateUserById(1, $data);

        $userUpdated = $userRepository->findUserOfId(1);

        $this->assertEquals(
            $data,
            $userUpdated->jsonSerialize()
        );
    }

    public function testDeleteUserById()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);
        $userRepository->deleteUserById(1);

        $this->assertCount(0, $userRepository->findAll());
    }

    public function testUsernameExistsWithId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $hasUsername = $userRepository->emailExists('bill.gates', $user->getId());

        $this->assertFalse($hasUsername);
    }


    public function testUsernameExistsWithoutId()
    {
        $user = $this->userMock();

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $hasUsername = $userRepository->emailExists('bill.gates');

        $this->assertTrue($hasUsername);
    }

    private function userMock(): User
    {
        return new User('bill.gates', 'Bill', 'Gates', 1);
    }
}
