<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
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
     * @ORM\Column(type="integer")
     */
    private $numberProduct;

    /**
     * @ORM\Column(type="float")
     */
    private $totalAmount;


    /**
     * @ORM\Column(type="float")
     */
    private $productAmount;



    public function __construct()
    {
        $this->product = new ArrayCollection();
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

    public function getNumberProduct(): ?int
    {
        return $this->numberProduct;
    }

    public function setNumberProduct(int $numberProduct): self
    {
        $this->numberProduct = $numberProduct;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getProductAmount(): ?float
    {
        return $this->productAmount;
    }

    public function setProductAmount(float $productAmount): self
    {
        $this->productAmount = $productAmount;

        return $this;
    }

}
