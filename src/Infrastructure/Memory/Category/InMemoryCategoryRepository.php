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
            1 => new Category(1, 'Categoria 1'),
            2 => new Category(2, 'Categoria 2'),
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

    /**
     * @param array{name: string} $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        $id = 1;
        if (count($this->categories) > 0) {
            $last = $this->categories[count($this->categories)];
            $id = $last->getId() + 1;
        }
        $newCategory = new Category(id: $id, name: 'Categoria 1');
        $this->categories[] = $newCategory;

        return $newCategory;
    }


    public function updateCategoryById($id, array $data): void
    {
        $category = $this->findCategoryById($id);
        $category->setName($data['name']);
    }

    public function deleteById(int $id): void
    {
        $category = $this->findCategoryById($id);
        unset(
            $this->categories[$category->getId()]
        );
    }
}