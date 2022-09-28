<?php

namespace App\Entity;

use App\Repository\DeviceModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceModelRepository::class)]
class DeviceModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'deviceModels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DeviceType $deviceType = null;

    #[ORM\ManyToMany(targetEntity: Document::class, inversedBy: 'deviceModels')]
    private Collection $documents;

    #[ORM\ManyToMany(targetEntity: SparePart::class, mappedBy: 'device')]
    private Collection $spareParts;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->spareParts = new ArrayCollection();
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

    public function getDeviceType(): ?DeviceType
    {
        return $this->deviceType;
    }

    public function setDeviceType(?DeviceType $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        $this->documents->removeElement($document);

        return $this;
    }

    /**
     * @return Collection<int, SparePart>
     */
    public function getSpareParts(): Collection
    {
        return $this->spareParts;
    }

    public function addSparePart(SparePart $sparePart): self
    {
        if (!$this->spareParts->contains($sparePart)) {
            $this->spareParts->add($sparePart);
            $sparePart->addDevice($this);
        }

        return $this;
    }

    public function removeSparePart(SparePart $sparePart): self
    {
        if ($this->spareParts->removeElement($sparePart)) {
            $sparePart->removeDevice($this);
        }

        return $this;
    }
}
