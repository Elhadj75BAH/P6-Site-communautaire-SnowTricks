<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateurs implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="utilisateurs", orphanRemoval=true)
     */
    private $auteurCommentaire;

    /**
     * @ORM\OneToMany(targetEntity=Figure::class, mappedBy="utilisateurs")
     */
    private $auteurFigure;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->auteurCommentaire = new ArrayCollection();
        $this->auteurFigure = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $auteurCommentaire->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeAuteurCommentaire(Commentaires $auteurCommentaire): self
    {
        if ($this->auteurCommentaire->removeElement($auteurCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($auteurCommentaire->getUtilisateurs() === $this) {
                $auteurCommentaire->setUtilisateurs(null);
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
            $auteurFigure->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeAuteurFigure(Figure $auteurFigure): self
    {
        if ($this->auteurFigure->removeElement($auteurFigure)) {
            // set the owning side to null (unless already changed)
            if ($auteurFigure->getUtilisateurs() === $this) {
                $auteurFigure->setUtilisateurs(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
