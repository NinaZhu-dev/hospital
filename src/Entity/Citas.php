<?php

namespace App\Entity;

use App\Repository\CitasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitasRepository::class)]
class Citas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column]
    private ?int $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Especialidades $especialidad = null;

    #[ORM\Column(length: 255)]
    private ?string $observaciones = null;

    #[ORM\Column(nullable: true)]
    private ?bool $gestionada = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaCita = null;

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

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): static
    {
        $this->telefono = $telefono;

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

    public function getEspecialidad(): ?Especialidades
    {
        return $this->especialidad;
    }

    public function setEspecialidad(Especialidades $especialidad): static
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function isGestionada(): ?bool
    {
        return $this->gestionada;
    }

    public function setGestionada(?bool $gestionada): static
    {
        $this->gestionada = $gestionada;

        return $this;
    }

    public function getFechaCita(): ?\DateTimeInterface
    {
        return $this->fechaCita;
    }

    public function setFechaCita(?\DateTimeInterface $fechaCita): static
    {
        $this->fechaCita = $fechaCita;

        return $this;
    }
}
