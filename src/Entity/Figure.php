<?php

namespace App\Entity;

use App\Repository\FigureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FigureRepository::class)
 * @UniqueEntity(fields={"nom"}, message="Il existe déjà ce nom. veillez saisir un autre ")
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
     * @ORM\Column(type="string", length=255,  unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=5,
     *     max=300,
     *     minMessage="Vous devez saisir un text un peu long",
     *     maxMessage="Votre text est beaucoup trop long"
     * )
     */
    private $description;



    /**
     * @ORM\ManyToOne(targetEntity=GroupeFigure::class, inversedBy="figure")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="ce champ ne peut être vide ")
     */
    private $groupe;

    /**
     * @ORM\OneToMany(targetEntity=ImageFigure::class, mappedBy="figureimage", orphanRemoval=true ,cascade={"remove"})
     */
    private $imagefig;

    /**
     * @ORM\OneToMany(targetEntity=VideoFigure::class, mappedBy="figure",cascade={"remove"})
     */
    private $videofig;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="auteurFigure")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="figure",cascade={"remove"})
     * @ORM\OrderBy({"dateDuCommentaire"="DESC"})
     */
    private $commentaire;

    public function __construct()
    {
        $this->imagefig = new ArrayCollection();
        $this->videofig = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
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

    public function getUtilisateurs(): ?Utilisateurs
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?Utilisateurs $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }

    public function __toString()
    {
        $nomfigure = $this->getNom();
        return($nomfigure);

    }
    
    //SLUG
    public static function slugify($nom, string $divider = '-')
    {
        // replace non letter or digits by divider
        $nom = preg_replace('~[^\pL\d]+~u', $divider, $nom);

        // transliterate
        $nom = iconv('utf-8', 'us-ascii//TRANSLIT', $nom);

        // remove unwanted characters
        $nom = preg_replace('~[^-\w]+~', '', $nom);

        // trim
        $nom = trim($nom, $divider);

        // remove duplicate divider
        $nom = preg_replace('~-+~', $divider, $nom);

        // lowercase
        $nom = strtolower($nom);

        if (empty($nom)) {
            return 'n-a';
        }

        return $nom;
    }
    // SLUG

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setFigure($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getFigure() === $this) {
                $commentaire->setFigure(null);
            }
        }

        return $this;
    }


}
