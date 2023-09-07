<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryLoader implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $categories = [
            ['name' => 'Combustível / Condução', 'type' => MovementTypeEnum::OUTFLOW],
            ['name' => 'Gastos Fixos', 'type' => MovementTypeEnum::OUTFLOW],
            ['name' => 'Vestuário', 'type' => MovementTypeEnum::OUTFLOW],
            ['name' => 'Presentes', 'type' => MovementTypeEnum::OUTFLOW],
            ['name' => 'Alimentação / Mercado', 'type' => MovementTypeEnum::OUTFLOW],
            ['name' => 'Oferta / Dízimo', 'type' => MovementTypeEnum::OUTFLOW],

            ['name' => 'Salário', 'type' => MovementTypeEnum::INFLOW],
            ['name' => 'Freelancer', 'type' => MovementTypeEnum::INFLOW],
        ];

        foreach ($categories as $categoryData) {
            $category = new Category(
                name: $categoryData['name'],
                type: $categoryData['type']
            );
            
            $manager->persist($category);
        }
        
        $manager->flush();
    }
}