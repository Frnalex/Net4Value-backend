<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    private string $code;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $dateExpiration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setcode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDateExpiration(): ?int
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?int $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function isExpired()
    {
        if ($this->getDateExpiration() === null) {
            return false;
        }

        return $this->getDateExpiration() < (new DateTimeImmutable())->getTimestamp();
    }
}
