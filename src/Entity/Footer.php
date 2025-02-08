<?php

namespace App\Entity;

use App\Repository\FooterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FooterRepository::class)]
class Footer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $enlace = null;

    #[ORM\Column]
    private ?int $fila = null;

    #[ORM\Column]
    private ?int $columna = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getEnlace(): ?string
    {
        return $this->enlace;
    }

    public function setEnlace(string $enlace): static
    {
        $this->enlace = $enlace;

        return $this;
    }

    public function getFila(): ?int
    {
        return $this->fila;
    }

    public function setFila(int $fila): static
    {
        $this->fila = $fila;

        return $this;
    }

    public function getColumna(): ?int
    {
        return $this->columna;
    }

    public function setColumna(int $columna): static
    {
        $this->columna = $columna;

        return $this;
    }
}
