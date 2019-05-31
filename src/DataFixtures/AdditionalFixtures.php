<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
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
            ->setEmail("linas.linartas@nfq.lt")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER']);

        $manager->persist($linas);

        $egle = new User();
        $egle->setName("Eglė G.")
            ->setCreatedAt(new \DateTime())
            ->setEmail("egle@mailinator.com")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER']);

        $manager->persist($egle);

        $ivona = new User();
        $ivona->setName("Ivona")
            ->setCreatedAt(new \DateTime())
            ->setEmail("ivona@mailinator.com")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER']);

        $manager->persist($ivona);

        $toma = new User();
        $toma->setName("Toma")
            ->setCreatedAt(new \DateTime())
            ->setEmail("toma@mailinator.com")
            ->setCity($this->getReference('Vilnius'))
            ->setIsConfirmed(true)
            ->setRoles(['ROLE_USER']);

        $manager->persist($toma);

        $advert = new Advert();
        $advert->setTitle('Išskalbti rūbus')
            ->setText("Žmona atsisakė")
            ->setCreatedAt(new \DateTime())
            ->setCity($this->getReference('Vilnius'))
            ->setUser($linas)
            ->setIsConfirmed(true)
            ->setIsDeleted(false)
            ->addCategory($this->getReference('kasdieniai-darbai'));

        $manager->persist($advert);

        $offer1 = new Offer();
        $offer1->setUser($egle)
            ->setText('Nieko keisto, kad žmona atsisakė. Galiu atvažiuot šeštadienį.')
            ->setAdvert($advert)
            ->setCreatedAt(new \DateTime())
            ->setIsConfirmed(true);

        $manager->persist($offer1);

        $offer2 = new Offer();
        $offer2->setUser($ivona)
            ->setText('Labas, dirbu skalbykloje, turiu ilgametę patirtį drabužių valyme. Kilogramo kaina - 15 Eur. Užsakymą atlikčiau per dvi darbo dienas.')
            ->setAdvert($advert)
            ->setCreatedAt(new \DateTime())
            ->setIsConfirmed(true);

        $manager->persist($offer2);

        $offer3 = new Offer();
        $offer3->setUser($toma)
            ->setText('Sveiki, namų tvarkytoja dirbu jau dešimt metų. Šiuo metu ieškausi papildomo darbo, galiu kiekvieną šeštadienį surinkti iš jūsų skalbinius, o sekmadienį po pietų pristatyti išplautus.')
            ->setAdvert($advert)
            ->setCreatedAt(new \DateTime())
            ->setIsConfirmed(true);

        $manager->persist($offer3);

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