<?php

namespace App\Entity;

use App\Repository\ItineraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItineraireRepository::class)]
class Itineraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lieux = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'itineraires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $membre = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'itineraires')]
    private Collection $categorie;

    #[ORM\OneToMany(mappedBy: 'itineraire', targetEntity: CommentairesItineraire::class, orphanRemoval: true)]
    private Collection $commentairesItineraires;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->commentairesItineraires = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): static
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getMembre(): ?User
    {
        return $this->membre;
    }

    public function setMembre(?User $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): static
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): static
    {
        $this->categorie->removeElement($categorie);

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
            $commentairesItineraire->setItineraire($this);
        }

        return $this;
    }

    public function removeCommentairesItineraire(CommentairesItineraire $commentairesItineraire): static
    {
        if ($this->commentairesItineraires->removeElement($commentairesItineraire)) {
            // set the owning side to null (unless already changed)
            if ($commentairesItineraire->getItineraire() === $this) {
                $commentairesItineraire->setItineraire(null);
            }
        }

        return $this;
    }
}
