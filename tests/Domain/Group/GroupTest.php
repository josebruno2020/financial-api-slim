<?php

declare(strict_types=1);

namespace Tests\Domain\Group;

use App\Domain\Group\Group;
use App\Domain\Helper\DateTimeHelper;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use UserActionTestHelper;

    public function testCreateGroup()
    {
        $user = $this->createMockUser();
        $now = new \DateTime();
        $name = 'Grupo de Teste';
        $description = 'Legal';
        $group = new Group(
            createdBy: $user,
            name: $name,
            description: $description
        );
        
        $this->assertEquals($name, $group->getName());
        $this->assertEquals($description, $group->getDescription());
        $this->assertEquals($user, $group->getUsers()[0]);
        $this->assertEquals(DateTimeHelper::formatDateTime($now), $group->getCreatedAt());
    }
}