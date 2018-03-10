<?php declare(strict_types=1);


namespace App\DataFixtures;


use App\Entity\Customer;
use App\Value\DeviceId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Value\Uuid;

class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $customer = new Customer(new Uuid('ff7cda4c-0670-4ebc-a945-a526fed124a6'), new DeviceId('12345'));

        $manager->persist($customer);
        $manager->flush();
    }
}