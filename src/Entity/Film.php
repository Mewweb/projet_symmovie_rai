<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\Length( max:255, maxMessage:"Le texte ne doit pas faire plus de 255 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $title = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length( max:255, maxMessage:"Le texte ne doit pas faire plus de 255 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]

    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Length( max:255, maxMessage:"Le texte ne doit pas faire plus de 255 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\Length( max:255, maxMessage:"Le texte ne doit pas faire plus de 255 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $genre = null;

    /**
     * @var Collection<int, UserFilm>
     */
    #[ORM\OneToMany(targetEntity: UserFilm::class, mappedBy: 'film')]
    private Collection $UserFilm;

    public function __construct()
    {
        $this->UserFilm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, UserFilm>
     */
    public function getUserFilm(): Collection
    {
        return $this->UserFilm;
    }

    public function addUserFilm(UserFilm $userFilm): static
    {
        if (!$this->UserFilm->contains($userFilm)) {
            $this->UserFilm->add($userFilm);
            $userFilm->setFilm($this);
        }

        return $this;
    }

    public function removeUserFilm(UserFilm $userFilm): static
    {
        if ($this->UserFilm->removeElement($userFilm)) {
            // set the owning side to null (unless already changed)
            if ($userFilm->getFilm() === $this) {
                $userFilm->setFilm(null);
            }
        }

        return $this;
    }
}
