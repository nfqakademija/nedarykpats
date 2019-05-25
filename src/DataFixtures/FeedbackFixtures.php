<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Feedback;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FeedbackFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $counter = 0;
        $acceptedOffersCounter = 0;

        while (true) {
            $referenceKey = AdvertFixtures::ADVERT_FIXTURE . '-' . $counter;

            if (!$this->hasReference($referenceKey)) {
                break;
            }

            /** @var Advert $advert */
            $advert = $this->getReference($referenceKey);

            if ($advert->getAcceptedOffer() === null) {
                $counter++;
                continue;
            }

            if ($acceptedOffersCounter % 2 === 0) {
                $acceptedOffersCounter++;
                $counter++;
                continue;
            }

            $feedback = new Feedback();
            $feedback->setScore(rand(2, 5))
                ->setAdvert($advert)
                ->setReceivingUser($advert->getAcceptedOffer()->getUser())
                ->setMessage('Puikiai atliktas darbas ');

            $manager->persist($feedback);

            $acceptedOffersCounter++;
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
            AcceptedOfferFixtures::class,
        ];
    }
}
