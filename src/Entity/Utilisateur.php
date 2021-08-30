<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $auteurCommentaire;

    /**
     * @ORM\OneToMany(targetEntity=Figure::class, mappedBy="utilisateur")
     */
    private $auteurFigure;

    public function __construct()
    {
        $this->auteurCommentaire = new ArrayCollection();
        $this->auteurFigure = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getAuteurCommentaire(): Collection
    {
        return $this->auteurCommentaire;
    }

    public function addAuteurCommentaire(Commentaires $auteurCommentaire): self
    {
        if (!$this->auteurCommentaire->contains($auteurCommentaire)) {
            $this->auteurCommentaire[] = $auteurCommentaire;
            $auteurCommentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAuteurCommentaire(Commentaires $auteurCommentaire): self
    {
        if ($this->auteurCommentaire->removeElement($auteurCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($auteurCommentaire->getUtilisateur() === $this) {
                $auteurCommentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Figure[]
     */
    public function getAuteurFigure(): Collection
    {
        return $this->auteurFigure;
    }

    public function addAuteurFigure(Figure $auteurFigure): self
    {
        if (!$this->auteurFigure->contains($auteurFigure)) {
            $this->auteurFigure[] = $auteurFigure;
            $auteurFigure->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAuteurFigure(Figure $auteurFigure): self
    {
        if ($this->auteurFigure->removeElement($auteurFigure)) {
            // set the owning side to null (unless already changed)
            if ($auteurFigure->getUtilisateur() === $this) {
                $auteurFigure->setUtilisateur(null);
            }
        }

        return $this;
    }
}
