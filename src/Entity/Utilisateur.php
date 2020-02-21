<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mailPerso;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Admin", mappedBy="compte", orphanRemoval=true)
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prof", mappedBy="compte", orphanRemoval=true)
     */
    private $prof;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="compte", orphanRemoval=true)
     */
    private $etudiant;

    public function __construct()
    {
        $this->admin = new ArrayCollection();
        $this->prof = new ArrayCollection();
        $this->etudiant = new ArrayCollection();
    }

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
    public function getMailPerso(): ?string
    {
        return $this->mailPerso;
    }

    public function setMailPerso(?string $mailPerso): self
    {
        $this->mailPerso = $mailPerso;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
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

    /**
     * @return Collection|Admin[]
     */
    public function getAdmin(): Collection
    {
        return $this->admin;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admin->contains($admin)) {
            $this->admin[] = $admin;
            $admin->setCompte($this);
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admin->contains($admin)) {
            $this->admin->removeElement($admin);
            // set the owning side to null (unless already changed)
            if ($admin->getCompte() === $this) {
                $admin->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Prof[]
     */
    public function getProf(): Collection
    {
        return $this->prof;
    }

    public function addProf(Prof $prof): self
    {
        if (!$this->prof->contains($prof)) {
            $this->prof[] = $prof;
            $prof->setCompte($this);
        }

        return $this;
    }

    public function removeProf(Prof $prof): self
    {
        if ($this->prof->contains($prof)) {
            $this->prof->removeElement($prof);
            // set the owning side to null (unless already changed)
            if ($prof->getCompte() === $this) {
                $prof->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiant(): Collection
    {
        return $this->etudiant;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiant->contains($etudiant)) {
            $this->etudiant[] = $etudiant;
            $etudiant->setCompte($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiant->contains($etudiant)) {
            $this->etudiant->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getCompte() === $this) {
                $etudiant->setCompte(null);
            }
        }

        return $this;
    }
}
