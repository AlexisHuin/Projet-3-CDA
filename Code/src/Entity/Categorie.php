<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToMany(targetEntity: Itineraire::class, mappedBy: 'categorie')]
    private Collection $itineraires;

    public function __construct()
    {
        $this->itineraires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
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
            $itineraire->addCategorie($this);
        }

        return $this;
    }

    public function removeItineraire(Itineraire $itineraire): static
    {
        if ($this->itineraires->removeElement($itineraire)) {
            $itineraire->removeCategorie($this);
        }

        return $this;
    }
}
