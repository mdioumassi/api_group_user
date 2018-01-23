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
        $groupe1->setNom("Administrateurs");
        $manager->persist($groupe1);

        $groupe2 = new Groupe();
        $groupe2->setNom("Editeur");
        $manager->persist($groupe2);

        $groupe3 = new Groupe();
        $groupe3->setNom("Contributeur");
        $manager->persist($groupe3);

        $manager->flush();

        $this->addReference('groupe1', $groupe1);
        $this->addReference('groupe2', $groupe2);
        $this->addReference('groupe3', $groupe3);
    }

}