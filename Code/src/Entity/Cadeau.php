<?php

namespace App\Entity;

use App\Repository\CadeauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CadeauRepository::class)]
class Cadeau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_partenaire = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $site_web_partenaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_expiration = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'cadeaux')]
    private Collection $membre;

    public function __construct()
    {
        $this->membre = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPartenaire(): ?string
    {
        return $this->nom_partenaire;
    }

    public function setNomPartenaire(string $nom_partenaire): static
    {
        $this->nom_partenaire = $nom_partenaire;

        return $this;
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

    public function getSiteWebPartenaire(): ?string
    {
        return $this->site_web_partenaire;
    }

    public function setSiteWebPartenaire(string $site_web_partenaire): static
    {
        $this->site_web_partenaire = $site_web_partenaire;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeImmutable
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeImmutable $date_expiration)
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
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

    /**
     * @return Collection<int, User>
     */
    public function getMembre(): Collection
    {
        return $this->membre;
    }

    public function addMembre(User $membre): static
    {
        if (!$this->membre->contains($membre)) {
            $this->membre->add($membre);
        }

        return $this;
    }

    public function removeMembre(User $membre): static
    {
        $this->membre->removeElement($membre);

        return $this;
    }
}
