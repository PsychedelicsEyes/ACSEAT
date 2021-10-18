<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amountTotal;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="orderUser")
     */
    private $userOrder;

    /**
     * @ORM\Column(type="boolean")
     */
    private $quantiteProduct;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function __construct()
    {
        $this->userOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmountTotal(): ?float
    {
        return $this->amountTotal;
    }

    public function setAmountTotal(float $amountTotal): self
    {
        $this->amountTotal = $amountTotal;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserOrder(): Collection
    {
        return $this->userOrder;
    }

    public function addUserOrder(User $userOrder): self
    {
        if (!$this->userOrder->contains($userOrder)) {
            $this->userOrder[] = $userOrder;
            $userOrder->setOrderUser($this);
        }

        return $this;
    }

    public function removeUserOrder(User $userOrder): self
    {
        if ($this->userOrder->removeElement($userOrder)) {
            // set the owning side to null (unless already changed)
            if ($userOrder->getOrderUser() === $this) {
                $userOrder->setOrderUser(null);
            }
        }

        return $this;
    }

    public function getQuantiteProduct(): ?bool
    {
        return $this->quantiteProduct;
    }

    public function setQuantiteProduct(bool $quantiteProduct): self
    {
        $this->quantiteProduct = $quantiteProduct;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
