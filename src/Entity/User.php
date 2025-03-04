<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\Length( max:30, maxMessage:"Le texte ne doit pas faire plus de 180 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $password = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\Length( max:30, maxMessage:"Le texte ne doit pas faire plus de 30 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $lastname = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\Length( max:30, maxMessage:"Le texte ne doit pas faire plus de 30 caractères")]
    #[Assert\NotBlank( message:"Veuillez remplir le champs")]
    private ?string $firstname = null;

    /**
     * @var Collection<int, UserFilm>
     */
    #[ORM\OneToMany(targetEntity: UserFilm::class, mappedBy: 'abonne', cascade: ['persist'])]
    private Collection $userFilm;

    public function __construct()
    {
        $this->userFilm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection<int, UserFilm>
     */
    public function getUserFilm(): Collection
    {
        return $this->userFilm;
    }

    public function addUserFilm(UserFilm $userFilm): static
    {
        if (!$this->userFilm->contains($userFilm)) {
            $this->userFilm->add($userFilm);
            $userFilm->setAbonne($this);
        }

        return $this;
    }

    public function removeUserFilm(UserFilm $userFilm): static
    {
        if ($this->userFilm->removeElement($userFilm)) {
            // set the owning side to null (unless already changed)
            if ($userFilm->getAbonne() === $this) {
                $userFilm->setAbonne(null);
            }
        }

        return $this;
    }
}
