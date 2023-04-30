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
     * @ORM\Column(type="string", length=255)
     */
    private $nom_seancelibre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="seancelibre")
     */
    private $user;

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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getNomSeanceLibre(): ?string
    {
        return $this->nom_seancelibre;
    }

    public function setNomSeanceLibre(string $nom_seancelibre): self
    {
        $this->nom_seancelibre = $nom_seancelibre;

        return $this;
    }

}
