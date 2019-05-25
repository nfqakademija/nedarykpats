<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdvertFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime(date('Y-m-d'));
        foreach ($this->getAdvertData() as $advertData) {
            $date->modify('-1 day');
            $advert = $this->createAdvert($advertData, $date->format('Y-m-d H:i:s'));
            $manager->persist($advert);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            CityFixtures::class,
            UserFixtures::class
        ];
    }

    /**
     * @param array $advert
     * @return Advert
     * @throws \Exception
     */
    private function createAdvert(array $advert, string $date)
    {
        $singleAdvert = new Advert();
        $singleAdvert
            ->setTitle($advert['title'])
            ->setText($advert['text'])
            ->setCreatedAt(new \DateTime($date))
            ->setCity($this->getReference($advert['city']))
            ->setUser($this->getReference($advert['email']))
            ->setIsConfirmed($advert['is_confirmed'])
            ->setIsDeleted(false);
        $collection = new ArrayCollection();
        foreach ($advert['categories'] as $category) {
            $collection->add($this->getReference($category));
            $singleAdvert->addCategory($this->getReference($category));
        }

        $this->addReference(
            $advert['reference'],
            $singleAdvert
        );

        return $singleAdvert;
    }


    /**
     * @return array
     */
    private function getAdvertData()
    {
        return
            [
                [
                    'reference' => 'laiptines-dazymas',
                    'city' => 'Vilnius',
                    'email' => 'aurimas@uzsakovas.lt',
                    'title' => 'Laiptinės dažymas',
                    'categories' => ['statybos', 'remontas'],
                    'text' => 'Reikalingi profesionalūs dažytojai, mokantys ir galintys perdažyti mūsų namų laiptinę. Namas - 5 aukštų.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'reikalingas-elektrikas',
                    'email' => 'martyna@uzsakove.lt',
                    'city' => 'Šalčinikai',
                    'title' => 'Reikalingas elektrikas',
                    'categories' => ['elektra'],
                    'text' => 'Reikalingas elektrikas 700m2 namo elektros instaliacijai įrengti. Objektas Trakų/Elektrėnų rajone.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'vonios-plyteliu',
                    'email' => 'vilius@uzsakovas.lt',
                    'city' => 'Šalčinikai',
                    'title' => 'Vonios plytelių klijavimas',
                    'categories' => ['apdailos-darbai', 'remontas'],
                    'text' => 'Norime atnaujinti vonią, ieškome plytelių klojėjo. Butas Vilniaus rajone, susiekimas automobiliu.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'reikalingas-sodininkas',
                    'email' => 'laurynas@uzsakovas.lt',
                    'city' => 'Vilnius',
                    'title' => 'Reikalingas Sodininkas',
                    'categories' => ['lauko-darbai'],
                    'text' => 'Reikalingas sodininkas privačiam namui Vilniuje (Antakalnis). Darbų apimtis: teritorijos tvarkymas, augalų sodinimas, ravėjimas, augalų ir medžių genėjimas ir t.t. Darbas pilna diena, 3-4 kartus per savaitę.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'ieskome-santechniko',
                    'email' => 'aurimas@uzsakovas.lt',
                    'city' => 'Vilnius',
                    'title' => 'Ieškome santechniko',
                    'categories' => ['remontas', 'santechnika'],
                    'text' => 'Reikalingas santechnikas visai buto santechnikai atnaujinti.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'silpnu-sroviu-montotuojas',
                    'email' => 'martyna@uzsakove.lt',
                    'city' => 'Šalčinikai',
                    'title' => 'Ieškome silpnų srovių montotuojo',
                    'categories' => ['elektra'],
                    'text' => 'Ieškome silpnų srovių montotuojo. darbo pobūdis - kabelių ir įrangos montavimas. Silpnų srovių komutavimo ir sistemų paleidimų gebėjimas - privalumas.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'darbų-vadovas',
                    'email' => 'vilius@uzsakovas.lt',
                    'city' => 'Vilnius',
                    'title' => 'Reikalingas darbų vadovas',
                    'categories' => ['remontas', 'apdailos-darbai', 'elektra', 'santechnika'],
                    'text' => 'Iešome darbų vadovo buto renovacijai. Butas - 60m2, mansarda, senamiestis.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'darbų-vadovas-2',
                    'email' => 'laurynas@uzsakovas.lt',
                    'city' => 'Šalčinikai',
                    'title' => 'Statybos vadovas Utenoje',
                    'categories' => ['remontas', 'apdailos-darbai', 'statybos'],
                    'text' => 'Ieškome atestuoto statybos darbų vadovo nedidelių objektų statybos darbams, t.p.griovimo darbams. Reikalavimai: vairuotojo pažymėjimas, dokumentų pildymas, darbas su klientais, jų paieška. Galime suteikti gyvenamąjį plotą darbo dienomis.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'technikos-pajungimas',
                    'email' => 'aurimas@uzsakovas.lt',
                    'city' => 'Šalčinikai',
                    'title' => 'Buitinės technikos pajungimas',
                    'categories' => ['buitines-technikos-pajungimas'],
                    'text' => 'Reikia pajungti visą buitinę techniką (indaplovę, kaitlentę, skalbimo mašiną, šaldytuvą, gartraukį) naujoje virtuvėje. Vilnius (Pašilaičiai).',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'baldu-isrinkimas',
                    'email' => 'martyna@uzsakove.lt',
                    'city' => 'Vilnius',
                    'title' => 'Baldų išrinkimas/surinkimas',
                    'categories' => ['remontas', 'baldai', 'kita'],
                    'text' => 'Kraustomės, reikia išrinkti visus baldus, o naujame bute surinkti. Vėliau būtų daugiau baldų, kuriuos reiktų surinkti',
                    'is_confirmed' => true,
                ],
            ];
    }
}
