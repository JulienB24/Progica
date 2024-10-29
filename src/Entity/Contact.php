<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Gite;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiResource(
        operations: [
            new Get(),
        ])]

    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $telephone = null;

    #[ORM\Column(length: 100)]
    private ?string $horairesDisponibilite = null;

    /**
     * @var Collection<int, Gite>
     */
    #[ORM\OneToMany(targetEntity: Gite::class, mappedBy: 'contact')]
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getHorairesDisponibilite(): ?string
    {
        return $this->horairesDisponibilite;
    }

    public function setHorairesDisponibilite(string $horairesDisponibilite): static
    {
        $this->horairesDisponibilite = $horairesDisponibilite;

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
            $gite->setContact($this);
        }

        return $this;
    }

    public function removeGite(Gite $gite): static
    {
        if ($this->gites->removeElement($gite)) {
            // set the owning side to null (unless already changed)
            if ($gite->getContact() === $this) {
                $gite->setContact(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom; // Ou toute autre propriété que vous souhaitez utiliser comme représentation textuelle
    }
}
