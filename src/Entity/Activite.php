<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_activite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_activite;

    /**
     * @ORM\OneToOne(targetEntity=SeanceLibre::class, cascade={"persist", "remove"})
     */
    private $seancelibre;

    /**
     * @ORM\OneToOne(targetEntity=SeanceCollective::class, cascade={"persist", "remove"})
     */
    private $seancecollective;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeActivite(): ?string
    {
        return $this->type_activite;
    }

    public function setTypeActivite(string $type_activite): self
    {
        $this->type_activite = $type_activite;

        return $this;
    }

    public function getNomActivite(): ?string
    {
        return $this->nom_activite;
    }

    public function setNomActivite(string $nom_activite): self
    {
        $this->nom_activite = $nom_activite;

        return $this;
    }

    public function getSeancelibre(): ?SeanceLibre
    {
        return $this->seancelibre;
    }

    public function setSeancelibre(?SeanceLibre $seancelibre): self
    {
        $this->seancelibre = $seancelibre;

        return $this;
    }

    public function getSeancecollective(): ?SeanceCollective
    {
        return $this->seancecollective;
    }

    public function setSeancecollective(?SeanceCollective $seancecollective): self
    {
        $this->seancecollective = $seancecollective;

        return $this;
    }
}
