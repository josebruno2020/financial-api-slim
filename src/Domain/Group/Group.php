<?php

declare(strict_types=1);

namespace App\Domain\Group;

use App\Domain\Helper\DateTimeHelper;
use App\Domain\Helper\JsonSerializeHelper;
use App\Domain\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: '`groups`')]
class Group implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    public function __construct(
        #[OneToOne(targetEntity: User::class)]
        #[JoinColumn(name: 'created_by', referencedColumnName: 'id')]
        private readonly User $createdBy,

        #[Column(type: 'string')]
        private string        $name,

        #[Column(name: '`description`', type: 'string', nullable: true)]
        private ?string       $description = null,

        #[ManyToMany(targetEntity: User::class, mappedBy: 'groups')]
        #[JoinTable(name: 'users_groups')]
        private Collection    $users = new ArrayCollection(),

        #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private readonly ?\DateTime $createdAt = new \DateTime(),

        ?int                        $id = null
    )
    {
        $this->setId($id)
            ->addUser($this->createdBy);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        $this->users->add($user);
        return $this;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setUsers(Collection $users): Group
    {
        $this->users = $users;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return DateTimeHelper::formatDateTime($this->createdAt);
    }

    public function getName(): string
    {
        return $this->name;
    }    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    
    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }    
}