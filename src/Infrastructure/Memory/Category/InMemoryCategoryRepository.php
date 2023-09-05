<?php

namespace App\Infrastructure\Memory\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;

class InMemoryCategoryRepository implements CategoryRepository
{
    /**
     * @var Category[] $categories
     */
    private array $categories;

    /**
     * @param Category[]|null $categories
     */
    public function __construct(array $categories = null)
    {
        $this->categories = $categories ?? [            
            1 => new Category(1, 'Categoria 1', new \DateTime('now')),
            2 => new Category(2, 'Categoria 2', new \DateTime('now')),
        ];
    }

    /**
     * @return Category[]
     */
    public function listCategories(string $order = 'asc' | 'desc'): array
    {
        return array_values($this->categories);
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id): ?Category
    {
        if (!isset($this->categories[$id])) {
            throw new CategoryNotFoundException();
        }
        
        return $this->categories[$id];
    }
}