<?php

namespace App\DataFixtures;

use App\Entity\Badge;
use App\Entity\Succes;
use App\Entity\Utilisateur;
use App\Utils\TextUtils;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UtilisateurFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    private TextUtils $textUtils;

    const GENRES = ['homme', 'femme'];

    public function __construct(UserPasswordHasherInterface $hasher, TextUtils $textUtils)
    {
        $this->hasher = $hasher;
        $this->textUtils = $textUtils;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /** @var array<array-key, Succes> $succes */
        $succes = $manager->getRepository(Succes::class)->findAll();

        /** @var array<array-key, Succes> $succes */
        $badges = $manager->getRepository(Badge::class)->findAll();

        for ($u = 1; $u <= 15; ++$u) {
            $user = new Utilisateur();

            $hash = $this->hasher->hashPassword($user, 'password');

            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $firstNameUnaccent = $this->textUtils->unaccent($firstName);
            $lastNameUnaccent = $this->textUtils->unaccent($lastName);

            $user
               ->setEmail(strtolower("{$firstNameUnaccent}.{$lastNameUnaccent}@gmail.com"))
               ->setMotDePasse($hash)
               ->setPrenom($firstName)
               ->setNom($lastName)
               ->setGenre(self::GENRES[array_rand(self::GENRES)])
               ->setDateDeNaissance(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-60 years', '-20 years')))
               ->setDateDeCreation(DateTimeImmutable::createFromMutable($faker->dateTimeThisYear('-2 months')))
               ->setDateDebutFreelancing(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', '-2 months')))
            ;

            shuffle($succes);

            foreach (array_slice($succes, 0, random_int(0, 5)) as $entity) {
                $user->addSucces($entity);
            }
            
            shuffle($badges);

            foreach (array_slice($badges, 0, random_int(0, 3)) as $badge) {
                $user->addBadge($badge);
            }
            
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SuccesFixtures::class,BadgeFixtures::class];
    }
}
