<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtilisateurRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource]
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity('email', message: 'Un utilisateur avec le même email est déjà enregistré')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $motDePasse = null;

    #[SerializedName('motDePasse')]
    private ?string $plainMotDePasse = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private DateTimeImmutable $dateDeNaissance;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $dateDeCreation;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $dateDebutFreelancing;

    #[ORM\ManyToMany(targetEntity: Badge::class)]
    private Collection $badges;

    #[ORM\ManyToMany(targetEntity: Succes::class)]
    private Collection $succes;

    #[ORM\Column(type: 'boolean')]
    private bool $estVerifie = false;

    #[ORM\OneToOne(targetEntity: Token::class, cascade: ['persist', 'remove'])]
    private ?Token $tokenEmailVerification;

    /**
     * @var array<array-key,string> $roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct()
    {
        $this->dateDeCreation = new DateTimeImmutable();
        $this->badges = new ArrayCollection();
        $this->succes = new ArrayCollection();
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

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeImmutable
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(?\DateTimeImmutable $dateDeNaissance): self
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeImmutable
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(\DateTimeImmutable $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getDateDebutFreelancing(): ?\DateTimeImmutable
    {
        return $this->dateDebutFreelancing;
    }

    public function setDateDebutFreelancing(\DateTimeImmutable $dateDebutFreelancing): self
    {
        $this->dateDebutFreelancing = $dateDebutFreelancing;

        return $this;
    }

    /**
     * @return Collection<int, Badge>
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges[] = $badge;
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        $this->badges->removeElement($badge);

        return $this;
    }

    /**
     * @return Collection<int, Succes>
    */
    public function getSucces(): Collection
    {
        return $this->succes;
    }

    public function addSucces(Succes $succes): self
    {
        if (!$this->succes->contains($succes)) {
            $this->succes[] = $succes;
        }

        return $this;
    }

    public function removeSucces(Succes $succes): self
    {
        $this->succes->removeElement($succes);

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<array-key,string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainMotDePasse = null;
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function getUserIdentifier(): string
    {
        return  $this->email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        // deprecated
    }

    public function getPlainMotDePasse(): ?string
    {
        return $this->plainMotDePasse;
    }
    public function setPlainMotDePasse(string $plainMotDePasse): self
    {
        $this->plainMotDePasse = $plainMotDePasse;
        return $this;
    }

    public function getEstVerifie(): bool
    {
        return $this->estVerifie;
    }

    public function setEstVerifie(bool $estVerifie): self
    {
        $this->estVerifie = $estVerifie;

        return $this;
    }

    public function getTokenEmailVerification(): ?Token
    {
        return $this->tokenEmailVerification;
    }

    public function setTokenEmailVerification(?Token $tokenEmailVerification): self
    {
        $this->tokenEmailVerification = $tokenEmailVerification;

        return $this;
    }
}
