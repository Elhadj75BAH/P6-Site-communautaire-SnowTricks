<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(
     *     min=5,
     *     max=1000,
     *     minMessage="Vous devez saisir un commentaire un peu long",
     *     maxMessage="Vous devez saisir un commentaire moyen long"
     * )
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDuCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="auteurCommentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="commentaire")
     */
    private $figure;



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

    public function getUtilisateurs(): ?Utilisateurs
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?Utilisateurs $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }
}
