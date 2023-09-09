<?php

namespace App\Infrastructure\Doctrine\Persistence\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryDeleteNotAllowedException;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DoctrineCategoryRepository implements CategoryRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function setRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Category::class);
    }

    /**
     * @return Category[]
     */
    public function listCategories(int $userId, int $type = 1, string $order = 'asc' | 'desc'): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('c')
        ->where('c.user = :user_id')
        ->orWhere('c.user IS NULL')
        ->andWhere('c.type = :type')
        ->setParameter('user_id', $userId)
        ->setParameter('type', MovementTypeEnum::make($type));
        //TODO: add order by
        return $q->getQuery()->getResult();
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id): ?Category
    {
        $repo = $this->setRepository();
        $category = $repo->find($id);
        if (!$category) {
            throw new CategoryNotFoundException();
        }
        
        /**
         * @var Category $category
         */
        return $category;
    }

    /**
     * @param array{name: string, userId: ?int, type: int} $data
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createCategory(array $data): Category
    {
        $category = new Category(
            name: $data['name'],
            user: $this->entityManager->getReference(User::class, $data['userId']),
            type: MovementTypeEnum::make($data['type'])
        );
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        
        return $category;
    }
    
    /**
     * @param $id
     * @param array{name: string} $data
     * @return void
     */
    public function updateCategoryById($id, array $data): void
    {
        $category = $this->findCategoryById($id);
        $category->setName($data['name']);
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function deleteById(int $id): void
    {
        $category = $this->findCategoryById($id);

        if (is_null($category->getUser())) {
            throw new CategoryDeleteNotAllowedException();
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }    
}