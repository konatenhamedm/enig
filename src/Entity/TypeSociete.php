<?php

namespace App\Entity;

use App\Repository\TypeSocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeSocieteRepository::class)
 */
class TypeSociete
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sigle;

    /**
     * @ORM\OneToMany(targetEntity=Documents::class, mappedBy="type",cascade={"persist"})
     */
    private $documents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=ActeConstitution::class, mappedBy="form")
     */
    private $acteConstitutions;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->acteConstitutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * @return Collection<int, Documents>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Documents $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setType($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getType() === $this) {
                $document->setType(null);
            }
        }

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, ActeConstitution>
     */
    public function getActeConstitutions(): Collection
    {
        return $this->acteConstitutions;
    }

    public function addActeConstitution(ActeConstitution $acteConstitution): self
    {
        if (!$this->acteConstitutions->contains($acteConstitution)) {
            $this->acteConstitutions[] = $acteConstitution;
            $acteConstitution->setForm($this);
        }

        return $this;
    }

    public function removeActeConstitution(ActeConstitution $acteConstitution): self
    {
        if ($this->acteConstitutions->removeElement($acteConstitution)) {
            // set the owning side to null (unless already changed)
            if ($acteConstitution->getForm() === $this) {
                $acteConstitution->setForm(null);
            }
        }

        return $this;
    }
}
