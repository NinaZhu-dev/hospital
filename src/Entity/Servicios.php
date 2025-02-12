<?php

namespace App\Entity;

use App\Repository\ServiciosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiciosRepository::class)]
class Servicios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Especialidades $especialidad = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $descripcion = null;

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

    public function getEspecialidad(): ?Especialidades
    {
        return $this->especialidad;
    }

    public function setEspecialidad(?Especialidades $especialidad): static
    {
        $this->especialidad = $especialidad;

        return $this;
    }

}
