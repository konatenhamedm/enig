<?php

namespace App\Entity;

use App\Repository\CourierArriveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourierArriveRepository::class)
 */
class CourierArrive
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
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReception;

    /**
     * @ORM\Column(type="text")
     */
    private $objet;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="arrive",cascade={"persist"})
     */
    private $fichiers;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="courierArrives")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $active;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="recep")
     */
    private $recep;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $existe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rangement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $expediteur;



    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

        return $this;
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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Fichier>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setArrive($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getArrive() === $this) {
                $fichier->setArrive(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


    public function getRecep(): ?Client
    {
        return $this->recep;
    }

    public function setRecep(?Client $recep): self
    {
        $this->recep = $recep;

        return $this;
    }

    public function isExiste(): ?bool
    {
        return $this->existe;
    }

    public function setExiste(?bool $existe): self
    {
        $this->existe = $existe;

        return $this;
    }

    public function getRangement(): ?string
    {
        return $this->rangement;
    }

    public function setRangement(string $rangement): self
    {
        $this->rangement = $rangement;

        return $this;
    }

    public function getExpediteur(): ?string
    {
        return $this->expediteur;
    }

    public function setExpediteur(string $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

}
