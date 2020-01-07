<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersProductsRepository")
 */
class OrdersProducts
{
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientOrder", inversedBy="orders_products") 
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false) 
     */
    protected $client_orders;

    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orders_products") 
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false) 
     */
    protected $products;

    /** 
     * @ORM\Column(type="integer") 
     */
    protected $amount;

    public function getClientOrders(): ?ClientOrder
    {
        return $this->client_orders;
    }

    public function setClientOrders(?ClientOrder $client_orders): self
    {
        $this->client_orders = $client_orders;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }    
}
