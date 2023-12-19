<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar_url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Itineraire::class, orphanRemoval: true)]
    private Collection $itineraires;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: CommentairesItineraire::class)]
    private Collection $commentairesItineraires;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: CommentairesLieu::class)]
    private Collection $commentairesLieus;

    #[ORM\ManyToMany(targetEntity: Cadeau::class, mappedBy: 'membre')]
    private Collection $cadeaux;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $favorite_places = null;

    #[ORM\Column]
    private ?int $gift_points = null;

    public function __construct()
    {
        $this->itineraires = new ArrayCollection();
        $this->commentairesItineraires = new ArrayCollection();
        $this->commentairesLieus = new ArrayCollection();
        $this->cadeaux = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->gift_points = 0;
        $this->avatar_url = "default.webp";
        $this->roles = ['ROLE_USER'];
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
    public function getUserIdentifier(): string
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

    public function setRoles(array $roles): static
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function setAvatarUrl(string $avatar_url): static
    {
        $this->avatar_url = $avatar_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }
    /**
     * @return Collection<int, Itineraire>
     */
    public function getItineraires(): Collection
    {
        return $this->itineraires;
    }

    public function addItineraire(Itineraire $itineraire): static
    {
        if (!$this->itineraires->contains($itineraire)) {
            $this->itineraires->add($itineraire);
            $itineraire->setMembre($this);
        }

        return $this;
    }

    public function removeItineraire(Itineraire $itineraire): static
    {
        if ($this->itineraires->removeElement($itineraire)) {
            // set the owning side to null (unless already changed)
            if ($itineraire->getMembre() === $this) {
                $itineraire->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentairesItineraire>
     */
    public function getCommentairesItineraires(): Collection
    {
        return $this->commentairesItineraires;
    }

    public function addCommentairesItineraire(CommentairesItineraire $commentairesItineraire): static
    {
        if (!$this->commentairesItineraires->contains($commentairesItineraire)) {
            $this->commentairesItineraires->add($commentairesItineraire);
            $commentairesItineraire->setMembre($this);
        }

        return $this;
    }

    public function removeCommentairesItineraire(CommentairesItineraire $commentairesItineraire): static
    {
        if ($this->commentairesItineraires->removeElement($commentairesItineraire)) {
            // set the owning side to null (unless already changed)
            if ($commentairesItineraire->getMembre() === $this) {
                $commentairesItineraire->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentairesLieu>
     */
    public function getCommentairesLieus(): Collection
    {
        return $this->commentairesLieus;
    }

    public function addCommentairesLieu(CommentairesLieu $commentairesLieu): static
    {
        if (!$this->commentairesLieus->contains($commentairesLieu)) {
            $this->commentairesLieus->add($commentairesLieu);
            $commentairesLieu->setMembre($this);
        }

        return $this;
    }

    public function removeCommentairesLieu(CommentairesLieu $commentairesLieu): static
    {
        if ($this->commentairesLieus->removeElement($commentairesLieu)) {
            // set the owning side to null (unless already changed)
            if ($commentairesLieu->getMembre() === $this) {
                $commentairesLieu->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cadeau>
     */
    public function getCadeaux(): Collection
    {
        return $this->cadeaux;
    }

    public function addCadeaux(Cadeau $cadeaux): static
    {
        if (!$this->cadeaux->contains($cadeaux)) {
            $this->cadeaux->add($cadeaux);
            $cadeaux->addMembre($this);
        }

        return $this;
    }

    public function removeCadeaux(Cadeau $cadeaux): static
    {
        if ($this->cadeaux->removeElement($cadeaux)) {
            $cadeaux->removeMembre($this);
        }

        return $this;
    }

    public function getFavoritePlaces(): ?string
    {
        return $this->favorite_places;
    }

    public function setFavoritePlaces(?string $favorite_places): static
    {
        $this->favorite_places = $favorite_places;

        return $this;
    }

    public function getGiftPoints(): ?int
    {
        return $this->gift_points;
    }

    public function setGiftPoints(int $gift_points): static
    {
        $this->gift_points = $gift_points;

        return $this;
    }
}




