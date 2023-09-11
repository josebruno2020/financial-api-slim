<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Enums\UserStatusEnum;
use App\Domain\Group\Group;
use App\Domain\Helper\DateTimeHelper;
use App\Domain\Helper\JsonSerializeHelper;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity, Table(name: 'users')]
class User implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', nullable: false)]
    private string $name;

    #[Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[Column(type: 'string', nullable: false)]
    private string $password;

    #[Column(type: 'string', nullable: false, enumType: UserStatusEnum::class, options: ['default' => UserStatusEnum::ACTIVE->value])]
    private UserStatusEnum $status;

    #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $createdAt;

    #[ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    #[JoinTable(name: 'users_groups')]
    private Collection $groups;

    public function __construct(string $email, string $name, string $password, ?int $id = null)
    {
        $this->setId($id)
            ->setEmail($email)
            ->setName($name)
            ->setPassword($password)
            ->setStatus(UserStatusEnum::ACTIVE)
            ->setCreatedAt();
    }

    public function setId(?int $id): User
    {
        if ($id) {
            $this->id = $id;
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = ucfirst($name);
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
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

    public function getStatus(): UserStatusEnum
    {
        return $this->status;
    }

    public function setStatus(UserStatusEnum $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $values = get_object_vars($this);
        unset($values['password']);
        unset($values['groups']);
        return JsonSerializeHelper::toJson($values);
    }
}
