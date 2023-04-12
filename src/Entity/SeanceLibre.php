<?php

namespace App\Entity;

use App\Repository\SeanceLibreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeanceLibreRepository::class)
 */
class SeanceLibre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_activite;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="seancelibre")
     */
    private $adherent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbActivite(): ?int
    {
        return $this->nb_activite;
    }

    public function setNbActivite(int $nb_activite): self
    {
        $this->nb_activite = $nb_activite;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }
}
