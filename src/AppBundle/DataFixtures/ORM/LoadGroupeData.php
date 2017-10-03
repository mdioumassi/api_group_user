<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 03/10/17
 * Time: 12:47
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGroupeData extends  Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $groupe1 = new Groupe();
        $groupe1->setNom("Administrateurs")
                ->addUser($this->getReference('user1'));
        $manager->persist($groupe1);

        $groupe2 = new Groupe();
        $groupe2->setNom("Editeur")
                ->addUser($this->getReference('user2'))
                ->addUser($this->getReference('user3'));
        $manager->persist($groupe2);

        $groupe3 = new Groupe();
        $groupe3->setNom("Contributeur");
        $manager->persist($groupe3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LoadUserData::class,
        ];
    }
}