<?php

declare(strict_types=1);

namespace App\Domain\Group;

use App\Domain\Enums\GroupInvitationStatusEnum;
use App\Domain\Helper\JsonSerializeHelper;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'group_invitations')]
class GroupInvitation implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    public function __construct(
        #[Column(type: 'string')]
        private string $email,
        
        #[ManyToOne(targetEntity: Group::class)]
        #[JoinColumn(name: 'group_id', referencedColumnName: 'id')]
        private readonly Group      $group,
        
        #[Column(type: 'string', nullable: false, enumType: GroupInvitationStatusEnum::class, options: ['default' => GroupInvitationStatusEnum::PENDING])]
        private GroupInvitationStatusEnum $status = GroupInvitationStatusEnum::PENDING,        
        
        #[Column(name: 'created_at', type: 'datetime', nullable: true, options: ['defaut' => 'CURRENT_TIMESTAMP'])]
        private readonly ?\DateTime $createdAt = new \DateTime(),
    )
    {
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

    public function getStatus(): GroupInvitationStatusEnum
    {
        return $this->status;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }
}