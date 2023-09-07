<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Helper\DateTimeHelper;
use App\Domain\Helper\JsonSerializeHelper;
use App\Domain\User\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity, Table(name: 'categories')]
class Category implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    public function __construct(
        #[Column(type: 'string', nullable: false)]
        private string              $name,

        #[ManyToOne(targetEntity: User::class)]
        #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        private readonly ?User      $user = null,

        #[Column(type: 'integer', nullable: false, enumType: MovementTypeEnum::class, options: ['default' => MovementTypeEnum::OUTFLOW])]
        private MovementTypeEnum $type = MovementTypeEnum::OUTFLOW,

        #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private readonly ?\DateTime $createdAt = new \DateTime(),

        ?int                        $id = null
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
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = ucfirst($name);
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getType(): MovementTypeEnum
    {
        return $this->type;
    }

    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }

    public function getCreatedAt(): string
    {
        return DateTimeHelper::formatDateTime($this->createdAt);
    }
}