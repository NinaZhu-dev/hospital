<?php

namespace App\Entity;

use App\Repository\EspecialidadesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspecialidadesRepository::class)]
class Especialidades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Medicos>
     */
    #[ORM\ManyToMany(targetEntity: Medicos::class, mappedBy: 'especialidad')]
    private Collection $medicos;

    #[ORM\Column(length: 255)]
    private ?string $categoria = null;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
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
     * @return Collection<int, Medicos>
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }

    public function addMedico(Medicos $medico): static
    {
        if (!$this->medicos->contains($medico)) {
            $this->medicos->add($medico);
            $medico->addEspecialidad($this);
        }

        return $this;
    }

    public function removeMedico(Medicos $medico): static
    {
        if ($this->medicos->removeElement($medico)) {
            $medico->removeEspecialidad($this);
        }

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }
}
