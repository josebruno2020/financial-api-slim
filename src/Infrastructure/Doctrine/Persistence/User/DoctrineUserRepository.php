<?php

namespace App\Infrastructure\Doctrine\Persistence\User;

use App\Domain\User\PasswordRepository;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DoctrineUserRepository implements UserRepository
{
    private EntityManager $em;
    private PasswordRepository $passwordRepository;

    public function __construct(EntityManager $em, PasswordRepository $passwordRepository)
    {
        $this->em = $em;
        $this->passwordRepository = $passwordRepository;
    }

    public function findAll(): array
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function findUserOfId(int $id): ?User
    {
        /**
         * @var User $user
         */
        $user =  $this->em->getRepository(User::class)->find($id);
        return $user;
    }

    /**
     * @param array{email: string, name: string, password: string} $data
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createUser(array $data): void
    {
        $password = $this->passwordRepository->setPassword($data['password']);
        $user = new User(email: $data['email'], name: $data['name'], password: $password);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function emailExists(string $email, ?int $id = null): bool
    {
        $q = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->where('u.email = :email');

        if ($id) {
            $q = $q->andWhere('u.id <> :id')
            ->setParameter('id', $id);
        }
        $result = $q->setParameter('email', $email)
            ->getQuery()->getResult();

        return count($result) > 0;
    }

    /**
     * @param int $id
     * @param array{email: string, name: string, password: string} $data
     * @return void
     */
    public function updateUserById(int $id, array $data): void
    {
        $user = $this->findUserOfId($id);
        $user
            ->setEmail($data['email'])
            ->setName($data['name']);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->findUserOfId($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $this->em->remove($user);
        $this->em->flush();
    }


}