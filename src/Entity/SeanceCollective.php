<?php

namespace App\Entity;

use App\Repository\SeanceCollectiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeanceCollectiveRepository::class)
 */
class SeanceCollective
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
    private $nb_place;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_seancecollective;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="seancecollective")
     */
    private $user;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(int $nb_place): self
    {
        $this->nb_place = $nb_place;

        return $this;
    }

    public function getNomSeanceCollective(): ?string
    {
        return $this->nom_seancecollective;
    }

    public function setNomSeanceCollective(string $nom_seancecollective): self
    {
        $this->nom_seancecollective = $nom_seancecollective;

        return $this;
    }
}
