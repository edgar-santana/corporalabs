<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientOrderRepository")
 */
class ClientOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * Many clients have one order. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="client_orders")
     * @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     */
    private $client;

    /**
     * Simulating ManyToMany relation trougth OrdersProducts entity
     * Many Orders have Many Products.
     * @ORM\OneToMany(targetEntity="App\Entity\OrdersProducts", mappedBy="client_orders")
     */
    private $orders_products;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    public function __construct() {
        $this->orders_products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
            $ordersProduct->setOrders($this);
        }

        return $this;
    }

    public function removeOrdersProduct(OrdersProducts $ordersProduct): self
    {
        if ($this->orders_products->contains($ordersProduct)) {
            $this->orders_products->removeElement($ordersProduct);
            // set the owning side to null (unless already changed)
            if ($ordersProduct->getOrders() === $this) {
                $ordersProduct->setOrders(null);
            }
        }

        return $this;
    }    
}
