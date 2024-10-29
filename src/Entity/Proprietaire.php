<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Gite;
use App\Repository\ProprietaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProprietaireRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
    ])]
class Proprietaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $telepone = null;

    /**
     * @var Collection<int, Gite>
     */
    #[ORM\OneToMany(targetEntity: Gite::class, mappedBy: 'proprietaire')]
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelepone(): ?string
    {
        return $this->telepone;
    }

    public function setTelepone(string $telepone): static
    {
        $this->telepone = $telepone;

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
            $gite->setProprietaire($this);
        }

        return $this;
    }

    public function removeGite(Gite $gite): static
    {
        if ($this->gites->removeElement($gite)) {
            // set the owning side to null (unless already changed)
            if ($gite->getProprietaire() === $this) {
                $gite->setProprietaire(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom; // Ou toute autre propriété que vous souhaitez utiliser comme représentation textuelle
    }
}