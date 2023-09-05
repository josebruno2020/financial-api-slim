<?php

namespace App\Infrastructure\Doctrine\Persistence\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
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
    public function listCategories(string $order = 'asc' | 'desc'): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('c');
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
     * @param array{name: string} $data
     * @return Category
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createCategory(array $data): Category
    {
        $category = new Category(name: $data['name']);
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
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }    
}