<?php

namespace App\Entity;

use App\Repository\PreguntasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreguntasRepository::class)]
class Preguntas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column]
    private ?bool $valoracion = null;

    /**
     * @var Collection<int, Respuestas>
     */
    #[ORM\OneToMany(targetEntity: Respuestas::class, mappedBy: 'pregunta')]
    private Collection $respuestas;

    #[ORM\ManyToOne(inversedBy: 'preguntas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoEncuesta $encuesta = null;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
    }

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function isValoracion(): ?bool
    {
        return $this->valoracion;
    }

    public function setValoracion(bool $valoracion): static
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    /**
     * @return Collection<int, Respuestas>
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuestas $respuesta): static
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas->add($respuesta);
            $respuesta->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuestas $respuesta): static
    {
        if ($this->respuestas->removeElement($respuesta)) {
            // set the owning side to null (unless already changed)
            if ($respuesta->getPregunta() === $this) {
                $respuesta->setPregunta(null);
            }
        }

        return $this;
    }

    public function getEncuesta(): ?TipoEncuesta
    {
        return $this->encuesta;
    }

    public function setEncuesta(?TipoEncuesta $encuesta): static
    {
        $this->encuesta = $encuesta;

        return $this;
    }
}
