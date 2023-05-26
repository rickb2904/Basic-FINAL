<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="inscriptions")
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=SeanceCollective::class, inversedBy="inscriptions")
     */
    private $seancecollective;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdherent(): ?User
    {
        return $this->adherent;
    }

    public function setAdherent(?User $adherent): self
    {
        $this->adherent = $adherent;

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
