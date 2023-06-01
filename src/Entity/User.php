<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity=FicheSante::class, mappedBy="user")
     */
    private $fichesan;

    /**
     * @ORM\OneToMany(targetEntity=SeanceLibre::class, mappedBy="user")
     */
    private $seancelibre;

    /**
     * @ORM\ManyToMany(targetEntity=SeanceCollective::class, mappedBy="user")
     */
    private $seancecollective;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="adherent")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
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
            $inscription->setAdherent($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getAdherent() === $this) {
                $inscription->setAdherent(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return "$this->nom $this->prenom";
    }

}