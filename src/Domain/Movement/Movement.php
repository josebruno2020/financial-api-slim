<?php

namespace App\Domain\Movement;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Helper\DateTimeHelper;
use App\Domain\Helper\JsonSerializeHelper;
use App\Domain\User\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'movements')]
class Movement implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[OneToMany(mappedBy: 'user', targetEntity: User::class)]
    private ?User $user;

    #[OneToMany(mappedBy: 'category', targetEntity: Category::class)]
    private Category $category;

    #[Column(type: 'integer', nullable: false, enumType: MovementTypeEnum::class)]
    private MovementTypeEnum $type;

    #[Column(type: 'decimal')]
    private float $value;

    #[Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $date;

    #[Column(type: 'string', nullable: true)]
    private ?string $obs;

    #[Column(name: 'created_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $createdAt;

    #[Column(name: 'updated_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getType(): MovementTypeEnum
    {
        return $this->type;
    }

    public function setType(MovementTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getDate(): string
    {
        return DateTimeHelper::formatDateTime($this->date);
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getObs(): ?string
    {
        return $this->obs;
    }

    public function setObs(?string $obs): self
    {
        $this->obs = $obs;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return DateTimeHelper::formatDateTime($this->createdAt);
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return DateTimeHelper::formatDateTime($this->updatedAt);
    }

    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }


    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }
}