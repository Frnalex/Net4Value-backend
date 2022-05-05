<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Utilisateur;
use App\UseCase\UtilisateurUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurDataPersister implements DataPersisterInterface
{
    public function __construct(
        private UtilisateurUseCase $utilisateurUseCase,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function supports($utilisateur): bool
    {
        return $utilisateur instanceof Utilisateur;
    }

    /**
     * @param Utilisateur $data
     */
    public function persist($utilisateur)
    {
        if ($utilisateur->getPlainMotDePasse()) {
            $this->utilisateurUseCase->updatePassword($utilisateur);
        }

        if ($utilisateur->getEmail()) {
            $this->utilisateurUseCase->updateEmail($utilisateur);
        }
        
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
