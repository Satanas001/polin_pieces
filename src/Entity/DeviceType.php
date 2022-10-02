<?php

namespace App\Entity;

use App\Repository\DeviceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceTypeRepository::class)]
class DeviceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'deviceTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'deviceType', targetEntity: DeviceModel::class)]
    private Collection $deviceModels;

    public function __construct()
    {
        $this->deviceModels = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, DeviceModel>
     */
    public function getDeviceModels(): Collection
    {
        return $this->deviceModels;
    }

    public function addDeviceModel(DeviceModel $deviceModel): self
    {
        if (!$this->deviceModels->contains($deviceModel)) {
            $this->deviceModels->add($deviceModel);
            $deviceModel->setDeviceType($this);
        }

        return $this;
    }

    public function removeDeviceModel(DeviceModel $deviceModel): self
    {
        if ($this->deviceModels->removeElement($deviceModel)) {
            // set the owning side to null (unless already changed)
            if ($deviceModel->getDeviceType() === $this) {
                $deviceModel->setDeviceType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDesignation() ;
    }
}
