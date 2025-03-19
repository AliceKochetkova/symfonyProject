<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->SetRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, 'admin@example.com');
        $user->setPassword($password);
        $manager->persist($user);

        $users = [];
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
            $manager->persist($user);

            $users[] = $user;

        }
        for ($i = 0; $i < 100; $i++) {
            shuffle($users);
            foreach ($users as $item) {
                $blog = (new Blog($item))
                    ->setTitle('Blog ' . $i)
                    ->setDescription('Blog Description ' . $i)
                    ->setText('Blog Text ' . $i);
                $manager->persist($blog);
            }
        }
        $manager->flush();
    }
}
