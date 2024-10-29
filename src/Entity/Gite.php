<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GiteRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
    ]
)]
class Gite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['gite:list', 'gite:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $region = null;

    #[ORM\Column(length: 50)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $departement = null;

    #[ORM\Column(length: 100)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $ville = null;

    #[ORM\Column(type: "float")]
    #[Groups(['gite:list', 'gite:item'])]
    private ?float $surfaceHabitable = null;

    #[ORM\Column]
    #[Groups(['gite:list', 'gite:item'])]
    private ?int $nombreChambre = null;

    #[ORM\Column]
    #[Groups(['gite:list', 'gite:item'])]
    private ?int $nombreCouchage = null;

    #[ORM\Column(type: "float")]
    #[Groups(['gite:list', 'gite:item'])]
    private ?float $tarifHebdo = null;

    #[ORM\Column(type: "boolean")]
    #[Groups(['gite:list', 'gite:item'])]
    private ?bool $accepteAnimaux = null;

    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'gites')]
    private Collection $equipements;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'gites')]
    private Collection $services;

    #[ORM\ManyToOne(inversedBy: 'gites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proprietaire $proprietaire = null;

    #[ORM\ManyToOne(inversedBy: 'gites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['gite:list', 'gite:item'])]
    private ?string $photo = null;

    #[ORM\Column(type: "float")]
    #[Groups(['gite:list', 'gite:item'])]
    private ?float $latitude = null;

    #[ORM\Column(type: "float")]
    #[Groups(['gite:list', 'gite:item'])]
    private ?float $longitude = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $distanceMax = null;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->services = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;
        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getSurfaceHabitable(): ?float
    {
        return $this->surfaceHabitable;
    }

    public function setSurfaceHabitable(float $surfaceHabitable): static
    {
        $this->surfaceHabitable = $surfaceHabitable;
        return $this;
    }

    public function getNombreChambre(): ?int
    {
        return $this->nombreChambre;
    }

    public function setNombreChambre(int $nombreChambre): static
    {
        $this->nombreChambre = $nombreChambre;
        return $this;
    }

    public function getNombreCouchage(): ?int
    {
        return $this->nombreCouchage;
    }

    public function setNombreCouchage(int $nombreCouchage): static
    {
        $this->nombreCouchage = $nombreCouchage;
        return $this;
    }

    public function getTarifHebdo(): ?float
    {
        return $this->tarifHebdo;
    }

    public function setTarifHebdo(float $tarifHebdo): static
    {
        $this->tarifHebdo = $tarifHebdo;
        return $this;
    }

    public function isAccepteAnimaux(): ?bool
    {
        return $this->accepteAnimaux;
    }

    public function setAccepteAnimaux(bool $accepteAnimaux): static
    {
        $this->accepteAnimaux = $accepteAnimaux;
        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->addGite($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            $equipement->removeGite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->addGite($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            $service->removeGite($this);
        }

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;
        return $this;
    }

    public function getProprietaire(): ?Proprietaire
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Proprietaire $proprietaire): static
    {
        $this->proprietaire = $proprietaire;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;
        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getDistanceMax(): ?float
    {
        return $this->distanceMax;
    }

    public function setDistanceMax(?float $distanceMax): static
    {
        $this->distanceMax = $distanceMax;
        return $this;
    }
}
