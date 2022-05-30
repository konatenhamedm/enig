<?php

namespace App\Entity;

use App\Repository\ActeConstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActeConstitutionRepository::class)
 */
class ActeConstitution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $objet;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $capital;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $natureAction;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $liberationSouscription;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nomGerant;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $siege;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $denomination;

    /**
     * @ORM\OneToMany(targetEntity=FichierConstitution::class, mappedBy="acte",cascade={"persist"})
     */
    private $fichierConstitutions;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="acteConstitutions")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=TypeSociete::class, inversedBy="acteConstitutions")
     */
    private $form;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $sigle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etat;

    public function __construct()
    {
        $this->fichierConstitutions = new ArrayCollection();

    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getCapital(): ?float
    {
        return $this->capital;
    }

    public function setCapital(float $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getNatureAction(): ?string
    {
        return $this->natureAction;
    }

    public function setNatureAction(string $natureAction): self
    {
        $this->natureAction = $natureAction;

        return $this;
    }

    public function getLiberationSouscription(): ?string
    {
        return $this->liberationSouscription;
    }

    public function setLiberationSouscription(string $liberationSouscription): self
    {
        $this->liberationSouscription = $liberationSouscription;

        return $this;
    }

    public function getNomGerant(): ?string
    {
        return $this->nomGerant;
    }

    public function setNomGerant(string $nomGerant): self
    {
        $this->nomGerant = $nomGerant;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->siege;
    }

    public function setSiege(string $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection<int, FichierConstitution>
     */
    public function getFichierConstitutions(): Collection
    {
        return $this->fichierConstitutions;
    }

    public function addFichierConstitution(FichierConstitution $fichierConstitution): self
    {
        if (!$this->fichierConstitutions->contains($fichierConstitution)) {
            $this->fichierConstitutions[] = $fichierConstitution;
            $fichierConstitution->setActe($this);
        }

        return $this;
    }

    public function removeFichierConstitution(FichierConstitution $fichierConstitution): self
    {
        if ($this->fichierConstitutions->removeElement($fichierConstitution)) {
            // set the owning side to null (unless already changed)
            if ($fichierConstitution->getActe() === $this) {
                $fichierConstitution->setActe(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getForm(): ?TypeSociete
    {
        return $this->form;
    }

    public function setForm(?TypeSociete $form): self
    {
        $this->form = $form;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


}
