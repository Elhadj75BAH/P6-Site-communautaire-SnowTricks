<?php

namespace App\Entity;

use App\Repository\FigureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FigureRepository::class)
 */
class Figure
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="auteurFigure")
     */
    private $utilisateur;

    /**
     * @ORM\OneToOne(targetEntity=GroupeFigure::class, inversedBy="figure", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    /**
     * @ORM\OneToMany(targetEntity=ImageFigure::class, mappedBy="figureimage", orphanRemoval=true)
     */
    private $imagefig;

    /**
     * @ORM\OneToMany(targetEntity=VideoFigure::class, mappedBy="figure")
     */
    private $videofig;

    public function __construct()
    {
        $this->imagefig = new ArrayCollection();
        $this->videofig = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getGroupe(): ?GroupeFigure
    {
        return $this->groupe;
    }

    public function setGroupe(GroupeFigure $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection|ImageFigure[]
     */
    public function getImagefig(): Collection
    {
        return $this->imagefig;
    }

    public function addImagefig(ImageFigure $imagefig): self
    {
        if (!$this->imagefig->contains($imagefig)) {
            $this->imagefig[] = $imagefig;
            $imagefig->setFigureimage($this);
        }

        return $this;
    }

    public function removeImagefig(ImageFigure $imagefig): self
    {
        if ($this->imagefig->removeElement($imagefig)) {
            // set the owning side to null (unless already changed)
            if ($imagefig->getFigureimage() === $this) {
                $imagefig->setFigureimage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VideoFigure[]
     */
    public function getVideofig(): Collection
    {
        return $this->videofig;
    }

    public function addVideofig(VideoFigure $videofig): self
    {
        if (!$this->videofig->contains($videofig)) {
            $this->videofig[] = $videofig;
            $videofig->setFigure($this);
        }

        return $this;
    }

    public function removeVideofig(VideoFigure $videofig): self
    {
        if ($this->videofig->removeElement($videofig)) {
            // set the owning side to null (unless already changed)
            if ($videofig->getFigure() === $this) {
                $videofig->setFigure(null);
            }
        }

        return $this;
    }
}
