<?php

namespace App\Entity;

use App\Repository\FichierConstitutionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=FichierConstitutionRepository::class)
 */
class FichierConstitution
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
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateObtention;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=ActeConstitution::class, inversedBy="fichierConstitutions")
     */
    private $acte;
    /**
     * @var UploadedFile
     */
    private $file;

    private $temp;
    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

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

    public function getDateObtention(): ?\DateTimeInterface
    {
        return $this->dateObtention;
    }

    public function setDateObtention(\DateTimeInterface $dateObtention): self
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath($path): self
    {

        if (!is_null($path)){
            $this->path = $path;
        }
       /* if(!is_null($path)){
        $this->path = $path;
        }*/


        return $this;
    }

    public function getActe(): ?ActeConstitution
    {
        return $this->acte;
    }

    public function setActe(?ActeConstitution $acte): self
    {
        $this->acte = $acte;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
