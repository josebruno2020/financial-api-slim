<?php

declare(strict_types=1);

namespace App\Infrastructure\Memory\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    /**
     * @param User[]|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new User('email@teste.com', 'Teste', '123123', 1),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    /**
     * @param array{email: string, name: string, password: string} $data
     */
    public function createUser(array $data): void
    {
        if (empty($this->users)) {
            $userId = 1;
        } else {
            $lastUser = $this->users[count($this->users)];
            $userId = $lastUser->getId() + 1;
        }
        $this->users[] = [
            $userId => new User(
                email: $data['email'],
                name: $data['name'],
                password: $data['password'],
                id: $userId
            )
        ];
    }

    public function emailExists(string $email, ?int $id = null): bool
    {
        $result = false;
        foreach ($this->users as $user) {
            if ($user->getId() !== $id && $user->getEmail() === $email) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param int $id
     * @param array{email: string, name: string} $data
     * @return void
     * @throws UserNotFoundException
     */
    public function updateUserById(int $id, array $data): void
    {
        $user = $this->users[$id];
        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->setName($data['name'])
            ->setEmail($data['email']);
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->findUserOfId($id);
        unset($this->users[$user->getId()]);
    }

    public function findUserByEmail(string $email): ?User
    {
        $result = null;
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                $result = $user;
            }
        }

        return $result;
    }
}
