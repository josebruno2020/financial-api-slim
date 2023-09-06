<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User|null
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): ?User;

    /**
     * @param array{email: string, name: string, password: string} $data
     */
    public function createUser(array $data): void;

    public function emailExists(string $email, ?int $id = null): bool;


    /**
     * @param int $id
     * @param array{email: string, name: string} $data
     * @return void
     */
    public function updateUserById(int $id, array $data): void;

    public function deleteUserById(int $id): void;
}
