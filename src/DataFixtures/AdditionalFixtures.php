<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdditionalFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $linas = new User();
        $linas->setName("Linas L.")
            ->setCreatedAt(new \DateTime())
            ->setEmail("linas@ngf.lt")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER'])
            ->setIdentification(md5(microtime()));

        $manager->persist($linas);

        $egle = new User();
        $egle->setName("Egle G.")
            ->setCreatedAt(new \DateTime())
            ->setEmail("egle@stalker.lt")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER'])
            ->setIdentification(md5(microtime()));

        $manager->persist($egle);

        $advert = new Advert();
        $advert->setTitle('Išskalbti rūbus')
            ->setText("Žmona atsisakė")
            ->setCreatedAt(new \DateTime())
            ->setCity($this->getReference('Vilnius'))
            ->setUser($linas)
            ->setIsConfirmed(true)
            ->setIsDeleted(false)
            ->addCategory($this->getReference('kita'));

        $manager->persist($advert);

        $offer = new Offer();
        $offer->setUser($egle)
            ->setText('in progress...')
            ->setAdvert($advert)
            ->setCreatedAt(new \DateTime())
            ->setIsConfirmed(true);

        $manager->persist($offer);

        $manager->flush();
    }


    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CityFixtures::class,
        ];
    }

}