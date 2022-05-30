<?php

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 */
class Archive
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
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Acte::class, inversedBy="archives")
     */
    private $acte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getActe(): ?Acte
    {
        return $this->acte;
    }

    public function setActe(?Acte $acte): self
    {
        $this->acte = $acte;

        return $this;
    }
}
