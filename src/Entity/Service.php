<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\Gite;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
    ]
)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $cout = null;

    /**
     * @var Collection<int, Gite>
     */
    #[ORM\ManyToMany(targetEntity: Gite::class, mappedBy: 'services')]
    private Collection $gites;

    public function __construct()
    {
        $this->gites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * @return Collection<int, Gite>
     */
    public function getGites(): Collection
    {
        return $this->gites;
    }

    public function addGite(Gite $gite): static
    {
        if (!$this->gites->contains($gite)) {
            $this->gites->add($gite);
            $gite->addService($this);
        }

        return $this;
    }

    public function removeGite(Gite $gite): static
    {
        if ($this->gites->removeElement($gite)) {
            $gite->removeService($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom; // Assurez-vous que cette propriété est une chaîne de caractères
    }
}