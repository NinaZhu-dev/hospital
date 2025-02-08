<?php

namespace App\Entity;

use App\Repository\PuestoTrabajoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PuestoTrabajoRepository::class)]
class PuestoTrabajo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, BolsaEmpleo>
     */
    #[ORM\OneToMany(targetEntity: BolsaEmpleo::class, mappedBy: 'puesto')]
    private Collection $bolsaEmpleos;

    #[ORM\Column]
    private ?bool $activo = null;

    public function __construct()
    {
        $this->bolsaEmpleos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, BolsaEmpleo>
     */
    public function getBolsaEmpleos(): Collection
    {
        return $this->bolsaEmpleos;
    }

    public function addBolsaEmpleo(BolsaEmpleo $bolsaEmpleo): static
    {
        if (!$this->bolsaEmpleos->contains($bolsaEmpleo)) {
            $this->bolsaEmpleos->add($bolsaEmpleo);
            $bolsaEmpleo->setPuesto($this);
        }

        return $this;
    }

    public function removeBolsaEmpleo(BolsaEmpleo $bolsaEmpleo): static
    {
        if ($this->bolsaEmpleos->removeElement($bolsaEmpleo)) {
            // set the owning side to null (unless already changed)
            if ($bolsaEmpleo->getPuesto() === $this) {
                $bolsaEmpleo->setPuesto(null);
            }
        }

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }
}
