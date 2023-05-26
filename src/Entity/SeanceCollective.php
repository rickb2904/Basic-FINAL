<?php

namespace App\Entity;

use App\Repository\SeanceCollectiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="seancecollective")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addSeancecollective($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSeancecollective($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSeancecollective($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            if ($inscription->getSeancecollective() === $this) {
                $inscription->setSeancecollective(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom_seancecollective;
    }
}
