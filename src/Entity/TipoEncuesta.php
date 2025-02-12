<?php

namespace App\Entity;

use App\Repository\TipoEncuestaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoEncuestaRepository::class)]
class TipoEncuesta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Preguntas>
     */
    #[ORM\OneToMany(targetEntity: Preguntas::class, mappedBy: 'encuesta')]
    private Collection $preguntas;

    public function __construct()
    {
        $this->preguntas = new ArrayCollection();
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
     * @return Collection<int, Preguntas>
     */
    public function getPreguntas(): Collection
    {
        return $this->preguntas;
    }

    public function addPregunta(Preguntas $pregunta): static
    {
        if (!$this->preguntas->contains($pregunta)) {
            $this->preguntas->add($pregunta);
            $pregunta->setEncuesta($this);
        }

        return $this;
    }

    public function removePregunta(Preguntas $pregunta): static
    {
        if ($this->preguntas->removeElement($pregunta)) {
            // set the owning side to null (unless already changed)
            if ($pregunta->getEncuesta() === $this) {
                $pregunta->setEncuesta(null);
            }
        }

        return $this;
    }
}
