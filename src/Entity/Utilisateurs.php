<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateursRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 * @UniqueEntity( 
 *      fields = {"email"},
 *      message="l'email est deja utilisé"
 * )
 */
class Utilisateurs  implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,minMessage="le nom doit contenir au moins deux carateres")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,minMessage="le prenom doit contenir au moins deux carateres")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,max=255)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8,minMessage="le mot de passe doit contenir au moins 8 carateres")
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_u;

    /**
     * @Assert\EqualTo(propertyPath="motDePasse", message="les mots de passe ne sont pas identiques ")
     */
    public $confirm_mdp;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getCreatedAtU(): ?\DateTimeInterface
    {
        return $this->createdAt_u;
    }

    public function setCreatedAtU(\DateTimeInterface $createdAt_u): self
    {
        $this->createdAt_u = $createdAt_u;

        return $this;
    }
    public function getRoles(){
        return ['ROLE_USER'];
    }
    public function getPassword(){
        return $this->motDePasse;
    }
    public function getSalt(){}

    public function getUsername(){} 
    public function eraseCredentials(){}
}
