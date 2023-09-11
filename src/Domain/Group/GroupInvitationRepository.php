<?php

declare(strict_types=1);

namespace App\Domain\Group;

interface GroupInvitationRepository
{
    public function sendInvitation(int $groupId, string $email): void;
}