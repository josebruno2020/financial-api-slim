<?php

declare(strict_types=1);

namespace App\Domain\Group;

use App\Domain\User\User;

interface GroupRepository
{
    public function listByUserId(int $userId);

    /**
     * @param array{userId: int, name: string, description: ?string} $data
     * @return Group
     */
    public function createGroup(array $data): Group;
    
    
    public function findGroupById(int $id): ?Group;

    /**
     * @param int $id
     * @return User[]
     */
    public function listUsersGroup(int $id): array;


    /**
     * @param int $id
     * @param array{name: string, description: ?string} $data
     * @return void
     */
    public function updateGroupById(int $id, array $data, int $userId): void;
    
    public function deleteGroupById(int $id, int $userId): void;
}