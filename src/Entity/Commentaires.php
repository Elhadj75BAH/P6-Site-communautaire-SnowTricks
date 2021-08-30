<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentairesRepository::class)
 */
class Commentaires
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDuCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="auteurCommentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    // Methode magic pour recuperer la date du commentaire
    public function __construct()
    {
        return $this->dateDuCommentaire = new \DateTime();
    }

    public function getDateDuCommentaire(): ?\DateTimeInterface
    {
        return $this->dateDuCommentaire;
    }

    public function setDateDuCommentaire(\DateTimeInterface $dateDuCommentaire): self
    {
        $this->dateDuCommentaire = $dateDuCommentaire;

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
}
