<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Simulating ManyToMany relation trougth OrdersProducts entity
     * Many Products have Many Orders.
     * @ORM\OneToMany(targetEntity="App\Entity\OrdersProducts", mappedBy="products")
     */
    private $orders_products;

    public function __construct() {
        $this->orders_products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|OrdersProducts[]
     */
    public function getOrdersProducts(): Collection
    {
        return $this->orders_products;
    }

    public function addOrdersProduct(OrdersProducts $ordersProduct): self
    {
        if (!$this->orders_products->contains($ordersProduct)) {
            $this->orders_products[] = $ordersProduct;
            $ordersProduct->setProducts($this);
        }

        return $this;
    }

    public function removeOrdersProduct(OrdersProducts $ordersProduct): self
    {
        if ($this->orders_products->contains($ordersProduct)) {
            $this->orders_products->removeElement($ordersProduct);
            // set the owning side to null (unless already changed)
            if ($ordersProduct->getProducts() === $this) {
                $ordersProduct->setProducts(null);
            }
        }

        return $this;
    }
}
