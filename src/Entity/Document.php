<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $filename = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?DocumentCategory $category = null;

    #[ORM\ManyToMany(targetEntity: DeviceModel::class, mappedBy: 'documents')]
    private Collection $deviceModels;

    public function __construct()
    {
        $this->deviceModels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getCategory(): ?DocumentCategory
    {
        return $this->category;
    }

    public function setCategory(?DocumentCategory $category): self
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
            $deviceModel->addDocument($this);
        }

        return $this;
    }

    public function removeDeviceModel(DeviceModel $deviceModel): self
    {
        if ($this->deviceModels->removeElement($deviceModel)) {
            $deviceModel->removeDocument($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFilename() ;
    }
}
