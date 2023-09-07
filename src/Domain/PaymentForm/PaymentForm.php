<?php

declare(strict_types=1);

namespace App\Domain\PaymentForm;

use App\Domain\Helper\JsonSerializeHelper;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'payment_forms')]
class PaymentForm implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    public function __construct(
        #[Column(type: 'string')]
        private readonly string    $name,
        #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private readonly \DateTime $createdAt = new \DateTime(),
        ?int                       $id = null
    )
    {
        $this->setId($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): PaymentForm
    {
        if ($id) {
            $this->id = $id;
        }
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }
}