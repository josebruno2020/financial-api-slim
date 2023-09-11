<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Persistence\Group;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Group\Group;
use App\Domain\Group\GroupActionNotAllowedException;
use App\Domain\Group\GroupRepository;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class DoctrineGroupRepository implements GroupRepository
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Group::class);
    }

    public function listByUserId(int $userId)
    {
        $repo = $this->getRepository();
        $q = $repo->createQueryBuilder('g');
        return $q->join('g.users', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()->getResult();
    }

    /**
     * @param array{userId: int, name: string, description: ?string} $data
     * @return Group
     * @throws ORMException
     */
    public function createGroup(array $data): Group
    {
        $group = new Group(
            createdBy: $this->entityManager->getReference(User::class, $data['userId']),
            name: $data['name'],
            description: $data['description'] ?? null
        );
        $this->entityManager->persist($group);
        $this->entityManager->flush();
        return $group;
    }

    public function findGroupById(int $id): ?Group
    {
        $repo = $this->getRepository();

        $group = $repo->find($id);
        if (!$group) {
            throw new CategoryNotFoundException();
        }
        /** @var Group $group */
        return $group;
    }

    /**
     * @param int $id
     * @return User[]
     */
    public function listUsersGroup(int $id): array
    {
        $userRepo = $this->entityManager->getRepository(User::class);
        $q = $userRepo->createQueryBuilder('u');
        return $q->join('u.groups', 'g')
            ->where('g.id = :groupId')
            ->setParameter('groupId', $id)
            ->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @param array{name: string, description: ?string} $data
     * @return void
     */
    public function updateGroupById(int $id, array $data, int $userId): void
    {
        $group = $this->findGroupById($id);

        if ($group->getCreatedBy()->getId() !== $userId) {
            throw new GroupActionNotAllowedException();
        }

        $group->setName($data['name'])
            ->setDescription($data['description']);
        
        $this->entityManager->persist($group);
        $this->entityManager->flush();

    }

    public function deleteGroupById(int $id, int $userId): void
    {
        $group = $this->findGroupById($id);

        if ($group->getCreatedBy()->getId() !== $userId) {
            throw new GroupActionNotAllowedException();
        }
        
        $this->entityManager->remove($group);
    }
}