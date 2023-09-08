<?php

namespace App\Domain\Category;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    public function listCategories(int $userId, int $type = 1, string $order = 'asc' | 'desc'): array;
    
    public function findCategoryById(int $id): ?Category;


    /**
     * @param array{name: string, userId: ?int} $data
     * @return Category
     */
    public function createCategory(array $data): Category;


    /**
     * @param $id
     * @param array{name: string} $data
     * @return void
     */
    public function updateCategoryById($id, array $data): void;
    
    public function deleteById(int $id): void;
}