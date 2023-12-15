<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Cadeau;
use App\Entity\User;
use App\Entity\CommentairesLieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**@let Generator */
    private Generator $faker;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setNom($this->faker->word())
                ->setPrenom($this->faker->word())
                ->setAvatarUrl($this->faker->word())
                ->setEmail($this->faker->email)
                ->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));

            $users[] = $user;
            $manager->persist($user);
        }

        $date_expiration = new \DateTimeImmutable('now');

        // Cadeaux
        for ($i = 0; $i < 50; $i++) {
            $cadeaux = new Cadeau();
            $cadeaux->setnom($this->faker->word())
                ->setNomPartenaire($this->faker->word())
                ->setSiteWebPartenaire($this->faker->url)
                ->setDateExpiration($date_expiration)
                ->setDescription($this->faker->text)
                ->addMembre($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($cadeaux);

        }
        // Commentaires Lieu
        for ($i = 0; $i < 50; $i++) {
            $commentairesLieu = new CommentairesLieu();
            $commentairesLieu->setTitre($this->faker->word())
                ->setDescription($this->faker->text)
                ->setLieuGps($this->faker->randomNumber())
                ->setNote(mt_rand(0, 5) == 5 ? mt_rand(0, 5) : null)
                ->setMembre($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($commentairesLieu);
        }
        $manager->flush();
    }
}
