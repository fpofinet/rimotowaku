<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomRessource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chemin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRessource(): ?string
    {
        return $this->nomRessource;
    }

    public function setNomRessource(string $nomRessource): self
    {
        $this->nomRessource = $nomRessource;

        return $this;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuteur(): ?Utilisateurs
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateurs $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }
}
