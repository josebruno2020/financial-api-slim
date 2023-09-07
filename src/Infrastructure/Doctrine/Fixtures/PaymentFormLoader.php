<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Domain\PaymentForm\PaymentForm;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaymentFormLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = ['Dinheiro', 'Cartão de Crédito', 'PIX', 'Débito'];

        foreach ($names as $name) {
            $paymentForm = new PaymentForm(name: $name);

            $manager->persist($paymentForm);
        }

        $manager->flush();
    }
}