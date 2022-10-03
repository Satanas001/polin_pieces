<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: DeviceType::class)]
    private Collection $deviceTypes;

    #[ORM\Column]
    private ?bool $active = true;

    public function __construct()
    {
        $this->deviceTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, DeviceType>
     */
    public function getDeviceTypes(): Collection
    {
        return $this->deviceTypes;
    }

    public function addDeviceType(DeviceType $deviceType): self
    {
        if (!$this->deviceTypes->contains($deviceType)) {
            $this->deviceTypes->add($deviceType);
            $deviceType->setCategory($this);
        }

        return $this;
    }

    public function removeDeviceType(DeviceType $deviceType): self
    {
        if ($this->deviceTypes->removeElement($deviceType)) {
            // set the owning side to null (unless already changed)
            if ($deviceType->getCategory() === $this) {
                $deviceType->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDesignation() ;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
