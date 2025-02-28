<?php

namespace App\Entity;

use App\Repository\UserFilmRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserFilmRepository::class)]
class UserFilm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\ManyToOne(inversedBy: 'userFilm')]
    private ?User $abonne = null;

    #[ORM\ManyToOne(inversedBy: 'UserFilm')]
    private ?Film $film = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getAbonne(): ?User
    {
        return $this->abonne;
    }

    public function setAbonne(?User $abonne): static
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): static
    {
        $this->film = $film;

        return $this;
    }
}
