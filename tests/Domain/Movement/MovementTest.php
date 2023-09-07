<?php

declare(strict_types=1);

namespace Tests\Domain\Movement;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\Movement;
use App\Domain\PaymentForm\PaymentForm;
use App\Domain\User\User;
use Tests\Application\Actions\Category\CategoryActionTestHelper;
use Tests\TestCase;

class MovementTest extends TestCase
{
    use CategoryActionTestHelper;

    public function movementProvider(): array
    {
        return [
            [1, $this->createCategoryMock(), 0, new PaymentForm(name: 'Dinheiro'), 50.0, date('Y-m-d H:i:s'), 'Legal'],
            [1, $this->createCategoryMock(), 0, new PaymentForm(name: 'Dinheiro'), 120.5, null, null]
        ];
    }

    /**
     * @dataProvider movementProvider
     * @param int $id
     * @param Category $category
     * @param int $type
     * @param PaymentForm $paymentForm
     * @param float $value
     * @param string|null $date
     * @param string|null $obs
     */
    public function testGetters(int $id, Category $category, int $type, PaymentForm $paymentForm, float $value, ?string $date, ?string $obs)
    {
        $movement = new Movement(
            category: $category,
            type: $type,
            value: $value,
            paymentForm: $paymentForm,
            date: $date,
            obs: $obs,
            id: $id
        );
        $dateTime = new \DateTime();
        $expectedDate = $date ?? date('Y-m-d H:i:s');

        $this->assertEquals($id, $movement->getId());
        $this->assertEquals($category, $movement->getCategory());
        $this->assertEquals(MovementTypeEnum::make($type), $movement->getType());
        $this->assertEquals($value, $movement->getValue());
        $this->assertEquals($expectedDate, $movement->getDate());
        $this->assertEquals($obs, $movement->getObs());
        $this->assertEquals($paymentForm, $movement->getPaymentForm());
        $this->assertEquals($dateTime->format('Y-m-d H:i:s'), $movement->getCreatedAt());
        $this->assertEquals($dateTime->format('Y-m-d H:i:s'), $movement->getUpdatedAt());
    }

    /**
     * @dataProvider movementProvider
     * @param int $id
     * @param Category $category
     * @param int $type
     * @param PaymentForm $paymentForm
     * @param float $value
     * @param string|null $date
     * @param string|null $obs
     */
    public function testJsonSerialize(int $id, Category $category, int $type, PaymentForm $paymentForm, float $value, ?string $date, ?string $obs)
    {
        $movement = new Movement(
            category: $category,
            type: $type,
            value: $value,
            paymentForm: $paymentForm,
            date: $date,
            obs: $obs,
            id: $id
        );
        $createdAt = new \DateTime();

        $expectedPayload = json_encode([
            'id' => $id,
            'user' => null,
            'category' => $category->jsonSerialize(),
            'type' => $type,
            'value' => $value,
            'date' => $date ?? date('Y-m-d H:i:s'),
            'obs' => $obs,
            'status' => $movement->getStatus(),
            'paymentForm' => $paymentForm->jsonSerialize(),
            'createdAt' => $createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $createdAt->format('Y-m-d H:i:s')
        ]);

        $this->assertEquals($expectedPayload, json_encode($movement));
    }
}
