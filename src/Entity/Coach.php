<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach extends User
{

    /**
     * @ORM\OneToMany(targetEntity=SeanceCollective::class, mappedBy="coach")
     */
    private $seancecollective;

    /**
     * @ORM\OneToMany(targetEntity=Adherent::class, mappedBy="coach")
     */
    private $adherent;

    public function __construct()
    {
        $this->seancecollective = new ArrayCollection();
        $this->adherent = new ArrayCollection();
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
            $seancecollective->setCoach($this);
        }

        return $this;
    }

    public function removeSeancecollective(SeanceCollective $seancecollective): self
    {
        if ($this->seancecollective->removeElement($seancecollective)) {
            // set the owning side to null (unless already changed)
            if ($seancecollective->getCoach() === $this) {
                $seancecollective->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adherent>
     */
    public function getAdherent(): Collection
    {
        return $this->adherent;
    }

    public function addAdherent(Adherent $adherent): self
    {
        if (!$this->adherent->contains($adherent)) {
            $this->adherent[] = $adherent;
            $adherent->setCoach($this);
        }

        return $this;
    }

    public function removeAdherent(Adherent $adherent): self
    {
        if ($this->adherent->removeElement($adherent)) {
            // set the owning side to null (unless already changed)
            if ($adherent->getCoach() === $this) {
                $adherent->setCoach(null);
            }
        }

        return $this;
    }
}
