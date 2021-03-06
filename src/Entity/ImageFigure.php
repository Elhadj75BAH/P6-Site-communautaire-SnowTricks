<?php

namespace App\Entity;

use App\Repository\ImageFigureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ImageFigureRepository::class)
 */
class ImageFigure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 , nullable=false)
     */
    private $image;

    /**
     * @var UploadedFile
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="imagefig")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figureimage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFigureimage(): ?Figure
    {
        return $this->figureimage;
    }

    public function setFigureimage(?Figure $figureimage): self
    {
        $this->figureimage = $figureimage;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    /**
     * @param UploadedFile $imageFile
     */
    public function setImageFile(?UploadedFile $imageFile): void
    {
        $this->imageFile = $imageFile;
    }
}
