<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startdate;

    /**
     * @ORM\Column(type="date")
     */
    private $enddate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Moto::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moto;

    /**
     * @ORM\Column(type="time")
     */
    private $starthour;

    /**
     * @ORM\Column(type="time")
     */
    private $endhour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pickuplocation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $returnlocation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getMoto(): ?Moto
    {
        return $this->moto;
    }

    public function setMoto(?Moto $moto): self
    {
        $this->moto = $moto;

        return $this;
    }

    public function getStarthour(): ?\DateTimeInterface
    {
        return $this->starthour;
    }

    public function setStarthour(\DateTimeInterface $starthour): self
    {
        $this->starthour = $starthour;

        return $this;
    }

    public function getEndhour(): ?\DateTimeInterface
    {
        return $this->endhour;
    }

    public function setEndhour(\DateTimeInterface $endhour): self
    {
        $this->endhour = $endhour;

        return $this;
    }

    public function getPickuplocation(): ?string
    {
        return $this->pickuplocation;
    }

    public function setPickuplocation(string $pickuplocation): self
    {
        $this->pickuplocation = $pickuplocation;

        return $this;
    }

    public function getReturnlocation(): ?string
    {
        return $this->returnlocation;
    }

    public function setReturnlocation(string $returnlocation): self
    {
        $this->returnlocation = $returnlocation;

        return $this;
    }
}
