<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
// use App\Entity\Client;
// use App\Entity\Product;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
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
     * @ORM\Column(type="integer")
     */
    private $id_client;
    
    /**
     * Many clients have one order. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="orders")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * Many Orders have Many Products.
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="orders")
     * @ORM\JoinTable(name="products")
     */
    private $products;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    // public function setCreatedAt(\DateTimeInterface $created_at): self
    public function setCreatedAt(): self
    {
        // $this->created_at = $created_at;
        $this->created_at = date('Y-m-d');

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->id_client;
    }

    public function setIdClient(int $id_client): self
    {
        $this->id_client = $id_client;

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
}
