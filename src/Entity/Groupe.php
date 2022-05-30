<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("groupe:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("groupe:read")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lien;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="groupes")
     */
    private $module;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\ManyToOne(targetEntity=Icons::class, inversedBy="groupes")
     */
    private $icon;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getIcon(): ?Icons
    {
        return $this->icon;
    }

    public function setIcon(?Icons $icon): self
    {
        $this->icon = $icon;

        return $this;
    }


}
