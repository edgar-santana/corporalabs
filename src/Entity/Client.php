<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * One client has many orders. This is the inverse side.
     * @ORM\OneToMany(targetEntity="App\Entity\ClientOrder", mappedBy="client")
     */
    private $client_orders;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct() {
        $this->orders = new ArrayCollection();
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

    /**
     * @return Collection|ClientOrder[]
     */
    public function getClientOrders(): Collection
    {
        return $this->client_orders;
    }

    public function addClientOrder(ClientOrder $client_order): self
    {
        if (!$this->client_orders->contains($client_order)) {
            $this->client_orders[] = $client_order;
            $client_order->setClient($this);
        }

        return $this;
    }

    public function removeClientOrder(ClientOrder $client_order): self
    {
        if ($this->client_orders->contains($client_order)) {
            $this->client_orders->removeElement($client_order);
            // set the owning side to null (unless already changed)
            if ($client_order->getClient() === $this) {
                $client_order->setClient(null);
            }
        }

        return $this;
    }
}
