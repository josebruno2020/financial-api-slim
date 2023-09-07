<?php

namespace App\Domain\Movement;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementStatusEnum;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Helper\DateTimeHelper;
use App\Domain\Helper\JsonSerializeHelper;
use App\Domain\PaymentForm\PaymentForm;
use App\Domain\User\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'movements')]
class Movement implements \JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[Column(type: 'integer', nullable: false, enumType: MovementTypeEnum::class, options: ['default' => MovementTypeEnum::OUTFLOW])]
    private MovementTypeEnum $type;

    #[Column(type: 'float')]
    private float $value;

    #[Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $date;

    #[Column(type: 'string', nullable: true)]
    private ?string $obs;

    #[Column(type: 'string', nullable: false, enumType: MovementStatusEnum::class, options: ['default' => MovementStatusEnum::PAID])]
    private MovementStatusEnum $status;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'payment_form_id', referencedColumnName: 'id')]
    private PaymentForm $paymentForm;

    #[Column(name: 'created_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $createdAt;

    #[Column(name: 'updated_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $updatedAt;

    public function __construct(
        Category    $category,
        int         $type,
        float       $value,
        PaymentForm $paymentForm,
        ?string     $date = null,
        ?User       $user = null,
        ?string     $obs = null,
        ?int        $id = null
    )
    {
        $this->setCategory($category)
            ->setType($type)
            ->setDate($date)
            ->setValue($value)
            ->setPaymentForm($paymentForm)
            ->setObs($obs)
            ->setId($id)
            ->setUser($user)
            ->setCreatedAt()
            ->setUpdatedAt()
            ->setStatus();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        if (!$id) {
            return $this;
        }
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

    public function setType(int $type): self
    {
        $this->type = MovementTypeEnum::make($type);
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

    public function getDate(): ?string
    {
        return DateTimeHelper::formatDateTime($this->date);
    }

    public function setDate(?string $date): self
    {
        $date = $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');
        $this->date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
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

    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getStatus(): MovementStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?MovementStatusEnum $status = MovementStatusEnum::PAID): self
    {
        if ($status) {
            $this->status = $status;
        }
        if ($this->type === MovementTypeEnum::INFLOW) {
            $this->status = MovementStatusEnum::RECEIVED;
        }
        if ($this->date->getTimestamp() > time()) {
            $this->status = MovementStatusEnum::SCHEDULED;
        }
        return $this;
    }

    public function getPaymentForm(): PaymentForm
    {
        return $this->paymentForm;
    }

    public function setPaymentForm(PaymentForm $paymentForm): self
    {
        $this->paymentForm = $paymentForm;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return JsonSerializeHelper::toJson(get_object_vars($this));
    }
}