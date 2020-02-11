<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganismeRepository")
 */
class Organisme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $justificatif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verifier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getJustificatif(): ?string
    {
        return $this->justificatif;
    }

    public function setJustificatif(?string $justificatif): self
    {
        $this->justificatif = $justificatif;

        return $this;
    }

    public function getVerifier(): ?bool
    {
        return $this->verifier;
    }

    public function setVerifier(bool $verifier): self
    {
        $this->verifier = $verifier;

        return $this;
    }
}
