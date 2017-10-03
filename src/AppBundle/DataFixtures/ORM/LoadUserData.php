<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 03/10/17
 * Time: 12:34
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setNom("Dioumassi")
              ->setPrenom("Mohamed")
              ->setEmail("mdioumassi@yahoo.fr")
              ->setActif("1");
        $manager->persist($user1);

        $user2 = new User();
        $user2->setNom("Pelletier")
            ->setPrenom("Nicolas")
            ->setEmail("p.nicolas@yahoo.fr")
            ->setActif("1");
        $manager->persist($user2);

        $user3 = new User();
        $user3->setNom("Bernat")
            ->setPrenom("Mathieu")
            ->setEmail("m.bernat@yahoo.fr")
            ->setActif("1");
        $manager->persist($user3);

        $manager->flush();

        $this->addReference("user1", $user1);
        $this->addReference("user2", $user2);
        $this->addReference("user3", $user3);
    }
}