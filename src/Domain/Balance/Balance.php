<?php

declare(strict_types=1);

namespace App\Domain\Balance;

use App\Domain\Helper\JsonSerializeHelper;
use App\Domain\User\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'balances')]
class Balance implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    public function __construct(
        #[ManyToOne(targetEntity: User::class)]
        #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        private User       $user,

        #[Column(type: 'float')]
        private float      $balance = 0,

        #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private \DateTime  $createdAt = new \DateTime(),

        #[Column(name: 'updated_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private \DateTime $updatedAt = new \DateTime(),

        ?int               $id = null,
    )
    {
        $this->setId($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        if ($id) {
            $this->id = $id;
        }
        return $this;
    }

    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }

    public function setBalance(float $balance): Balance
    {
        $this->balance = $balance;
        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}