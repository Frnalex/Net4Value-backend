<?php

namespace App\Utils;

use App\Entity\Token;
use DateTimeImmutable;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TokenUtils
{
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(TokenGeneratorInterface $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;
    }

    public function generate($validity = 3600)
    {
        $token = new Token();
        $token->setCode($this->tokenGenerator->generateToken());

        if ($validity !== null) {
            $now = new DateTimeImmutable();
            $token->setDateExpiration($now->getTimestamp() + $validity);
        }

        return $token;
    }
}
