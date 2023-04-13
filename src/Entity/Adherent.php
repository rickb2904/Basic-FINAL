<?php

namespace App\Entity;

use App\Repository\AdherentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdherentRepository::class)
 */
class Adherent extends User
{


    /**
     * @ORM\OneToMany(targetEntity=FicheSante::class, mappedBy="adherent")
     */
    private $fichesan;

    /**
     * @ORM\OneToMany(targetEntity=SeanceLibre::class, mappedBy="adherent")
     */
    private $seancelibre;

    /**
     * @ORM\ManyToMany(targetEntity=SeanceCollective::class, mappedBy="adherent")
     */
    private $seancecollective;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="adherent")
     */
    private $coach;

    public function __construct()
    {
        $this->fichesan = new ArrayCollection();
        $this->seancelibre = new ArrayCollection();
        $this->seancecollective = new ArrayCollection();
    }


    /**
     * @return Collection<int, FicheSante>
     */
    public function getFichesan(): Collection
    {
        return $this->fichesan;
    }

    public function addFichesan(FicheSante $fichesan): self
    {
        if (!$this->fichesan->contains($fichesan)) {
            $this->fichesan[] = $fichesan;
            $fichesan->setAdherent($this);
        }

        return $this;
    }

    public function removeFichesan(FicheSante $fichesan): self
    {
        if ($this->fichesan->removeElement($fichesan)) {
            // set the owning side to null (unless already changed)
            if ($fichesan->getAdherent() === $this) {
                $fichesan->setAdherent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SeanceLibre>
     */
    public function getSeancelibre(): Collection
    {
        return $this->seancelibre;
    }

    public function addSeancelibre(SeanceLibre $seancelibre): self
    {
        if (!$this->seancelibre->contains($seancelibre)) {
            $this->seancelibre[] = $seancelibre;
            $seancelibre->setAdherent($this);
        }

        return $this;
    }

    public function removeSeancelibre(SeanceLibre $seancelibre): self
    {
        if ($this->seancelibre->removeElement($seancelibre)) {
            // set the owning side to null (unless already changed)
            if ($seancelibre->getAdherent() === $this) {
                $seancelibre->setAdherent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SeanceCollective>
     */
    public function getSeancecollective(): Collection
    {
        return $this->seancecollective;
    }

    public function addSeancecollective(SeanceCollective $seancecollective): self
    {
        if (!$this->seancecollective->contains($seancecollective)) {
            $this->seancecollective[] = $seancecollective;
            $seancecollective->setAdherent($this);
        }

        return $this;
    }

    public function removeSeancecollective(SeanceCollective $seancecollective): self
    {
        if ($this->seancecollective->removeElement($seancecollective)) {
            // set the owning side to null (unless already changed)
            if ($seancecollective->getAdherent() === $this) {
                $seancecollective->setAdherent(null);
            }
        }

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }
}
