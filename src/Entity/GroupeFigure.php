<?php

namespace App\Entity;

use App\Repository\GroupeFigureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeFigureRepository::class)
 */
class GroupeFigure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Figure::class, mappedBy="groupe", cascade={"persist", "remove"})
     */
    private $figure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomGroupe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(Figure $figure): self
    {
        // set the owning side of the relation if necessary
        if ($figure->getGroupe() !== $this) {
            $figure->setGroupe($this);
        }

        $this->figure = $figure;

        return $this;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

        return $this;
    }
}
