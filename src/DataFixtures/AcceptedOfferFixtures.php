<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AcceptedOfferFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $counter = 0;

        while (true) {
            $referenceKey = AdvertFixtures::ADVERT_FIXTURE . '-' . $counter;

            if (!$this->hasReference($referenceKey)) {
                break;
            }

            /** @var Advert $advert */
            $advert = $this->getReference($referenceKey);

            if ($counter % 3 !== 0) {
                $counter++;
                continue;
            }

            $offers = $advert->getOffers();
            $advert->setAcceptedOffer($offers[rand(0, $offers->count())]);

            $counter++;
        }
        $manager->flush();
    }


    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            OfferFixtures::class,
        ];
    }
}
