<?php

namespace App\Entity;

use App\Repository\RespuestasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespuestasRepository::class)]
class Respuestas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'respuestas')]
    private ?Preguntas $pregunta = null;

    #[ORM\ManyToOne(inversedBy: 'respuestas')]
    private ?User $usuario = null;

    #[ORM\Column(nullable: true)]
    private ?int $valoracion = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPregunta(): ?Preguntas
    {
        return $this->pregunta;
    }

    public function setPregunta(?Preguntas $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getValoracion(): ?int
    {
        return $this->valoracion;
    }

    public function setValoracion(int $valoracion): static
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }
}
