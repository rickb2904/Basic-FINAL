<?php

namespace App\Entity;

use App\Repository\SeanceLibreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=Activite::class)
     */
    private $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    /**
     * @return Collection|Activite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        $this->activites->removeElement($activite);

        return $this;
    }
}
