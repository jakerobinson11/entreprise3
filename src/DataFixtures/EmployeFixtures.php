<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 7; $i++) {
            $employes = new Employe;
            $employes->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setService($faker->company)
                ->setSalaire(rand(1400, 4000));
            $manager->persist($employes);
        }
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);
    }
}
