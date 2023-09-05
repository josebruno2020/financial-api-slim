<?php

namespace App\Domain\Category;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity, Table(name: 'categories')]
class Category implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    #[Column(type: 'string', nullable: false)]
    private string $name;

    #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $createdAt;

    public function __construct(?int $id = null, ?string $name = null)
    {
        $this->setId($id)
            ->setName($name)
            ->setCreatedAt();
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
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();
        return $this;
    }

    public function jsonSerialize(): array
    {
        $values = get_object_vars($this);
        $values['createdAt'] = $this->createdAt?->format('Y-m-d H:i:s');
        return $values;
    }
}