<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametreRepository::class)
 */
class Parametre
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
    private $titre;

    /**
     * @var String
     * @ORM\Column(name="logo",type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleurHeader;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleurSide;

    /**
     * @ORM\Column(type="integer")
     */
    private $active;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCouleurHeader(): ?string
    {
        return $this->couleurHeader;
    }

    public function setCouleurHeader(string $couleurHeader): self
    {
        $this->couleurHeader = $couleurHeader;

        return $this;
    }

    public function getCouleurSide(): ?string
    {
        return $this->couleurSide;
    }

    public function setCouleurSide(string $couleurSide): self
    {
        $this->couleurSide = $couleurSide;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }
}
