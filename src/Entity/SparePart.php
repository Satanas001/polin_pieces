<?php

namespace App\Entity;

use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SparePartRepository::class)]
class SparePart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $reference = null;

    #[ORM\Column(length: 100)]
    private ?string $designation = null;
 
    #[ORM\Column(nullable: true)]
    private ?int $unitPrice = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isEnabled = true;

    #[ORM\ManyToMany(targetEntity: DeviceModel::class, inversedBy: 'spareParts')]
    private Collection $device;

    public function __construct()
    {
        $this->device = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
   

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * @return Collection<int, DeviceModel>
     */
    public function getDevice(): Collection
    {
        return $this->device;
    }

    public function addDevice(DeviceModel $device): self
    {
        if (!$this->device->contains($device)) {
            $this->device->add($device);
        }

        return $this;
    }

    public function removeDevice(DeviceModel $device): self
    {
        $this->device->removeElement($device);

        return $this;
    }

    public function __toString()
    {
        return sprintf('%s - %s', $this->getReference(), $this->getDesignation()) ;
    }
}
