<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OfferFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
       foreach ($this->getOfferData() as $offerData) {
           $offer = $this->createOffer($offerData);
           $manager->persist($offer);
       }
        $manager->flush();
    }


    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AdvertFixtures::class
        ];
    }


    /**
     * @param array $offerData
     * @return Offer
     * @throws \Exception
     */
    private function createOffer(array $offerData): Offer
    {
        $offer = new Offer();

        $offer->setUser($this->getReference($offerData['email']))
            ->setText($offerData['text'])
            ->setAdvert($this->getReference($offerData['advert']))
            ->setCreatedAt(new \DateTime('now'))
            ->setIsConfirmed($offerData['is_confirmed']);

        return $offer;
    }


    /**
     * @return array
     */
    private function getOfferData()
    {
        return
            [
                [
                    'reference' => 'baldu-isrinkimas-atsakymas',
                    'advert' => 'baldu-isrinkimas',
                    'email' => 'vilius@rangovas.lt',
                    'text' => 'Sveiki, galiu jums padėti šiuo klausimu. Vieno valandos kaina 12 Eur be PVM. Jeigu naudojamas mūsų transportas 14 Eur be PVM (esant didesniam atstumui nei 50 km, vieno kilometro kaina 0,5 Eur be PVM',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'technikos-pajungimas-atsakymas',
                    'advert' => 'technikos-pajungimas',
                    'email' => 'laurynas@rangovas.lt',
                    'text' => 'Individualiai taisau visus buitinius (ir ne tik) elektros prietaisus, atlieku visus elektros instaliacijos darbus, montuoju ir pajungiu.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'technikos-pajungimas-atsakymas-2',
                    'advert' => 'technikos-pajungimas',
                    'email' => 'aurimas@rangovas.lt',
                    'text' => 'Skalbimo mašinų, indaplovių, gartraukių, viryklių ir kitos technikos pajungimas. Visos kainos yra sutartinės.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas',
                    'advert' => 'darbų-vadovas',
                    'email' => 'martyna@rangove.lt',
                    'text' => 'Atestuotas techninis prižiūrėtojas, statybų vadovas, turintis ilgametę (15 metų) patirtį statinio statybų (darbų) vadovo pareigose, atlieka statinių statybų techninę priežiūrą (gyvenamieji ir negyvenamieji pastatai). Galiu vykdyti priežiūrą kas stato ūkio būdu ir konsultuoti su statyba susijusiais įvairiais klausimais. Turiu patirties su karkasinių namų statyba. Tikrinu pastatus ar pastatyti pagal projektą, statybos taisykles, statybos techninius reglamentus (STR) ar atitinka visus keliamus reikalavimus.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas-2',
                    'advert' => 'darbų-vadovas',
                    'email' => 'vilius@rangovas.lt',
                    'text' => 'Atestuotas techninės priežiūros vadovas, statybos vadovas papildomai atlieka techninę priežiūrą individualiems ir kt. statiniams.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas-3',
                    'advert' => 'darbų-vadovas',
                    'email' => 'laurynas@rangovas.lt',
                    'text' => 'Statybų vadovo paslaugos statantiems ūkio būdu, konsultacijos. Ypatingi (neypatingi) gyvenamieji ir negyvenamieji pastatai, kultūros paveldo objektai. Dirbame visoje Lietuvoje.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'montotuojas-atsakymas',
                    'advert' => 'silpnu-sroviu-montotuojas',
                    'email' => 'aurimas@rangovas.lt',
                    'text' => 'Specialistai, turintys ilgametę patirtį elektros instaliacijos srityje, atlieka lauko ir vidaus elektros instaliaciją, konsultuoja, pataria, padeda išsirinkti optimalų sprendimą, paruošia dokumentus ESO.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'ieskome-santechniko-atsakymas',
                    'advert' => 'ieskome-santechniko',
                    'email' => 'martyna@rangove.lt',
                    'text' => 'KODĖL VERTA SKAMBINTI BŪTENT MAN? OPERATYVUMAS: Priklausomai nuo darbų apimties ir pobūdžio dirbu vienas, o reikalui esant – kooperuojuosi. Jūsų patogumui – paslaugas teikiu ir savaitgaliais. PARTNERIAI: Bendradarbiauju su ilgamečiais, geriausią kokybės ir kainos santykį siūlančiais medžiagų tiekėjais. Dėka gero apyvartumo, sugebu suderėti aukštas nuolaidas. Dirbu ir su šeimininko medžiagomis. KONKURENCINGUMAS: Man nereikia išlaikyti vadybininkų, buhalterių ir direktorių "ant savo sprando", todėl galiu pasiūlyti konkurencingas paslaugų kainas bei suteikti NUOLAIDAS didesnės apimties montavimo darbams. MANDAGUMAS: Bendrauju maloniai ir korektiškai. Suteikiu visapusišką informaciją, dažniausiai galite rinktis iš kelių įmanomų variantų.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'ieskome-santechniko-atsakymas-2',
                    'advert' => 'ieskome-santechniko',
                    'email' => 'vilius@rangovas.lt',
                    'text' => 'Santechnikas Vilniuje operatyviai ir profesionaliai atlieka visus santechnikos montavimo ir remonto darbus.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'reikalingas-sodininkas-atsakymas',
                    'advert' => 'reikalingas-sodininkas',
                    'email' => 'laurynas@rangovas.lt',
                    'text' => 'Turiu darbo patirties šiose pareigose. Taip pat atlieku smulkius santechnikos,remonto ir kitus darbus.',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'vonios-plyteliu-atsakymas',
                    'advert' => 'vonios-plyteliu',
                    'email' => 'aurimas@rangovas.lt',
                    'text' => 'Kokybiškai klijuoju visu rūšių plyteles,plytelių supjovimas 45 laipsnių kampu,nuolydžių formavimas,hidroizoliacijos įrengimas ,sienų bei grindų lyginimas ir kiti papildomi darbai. Konsultuoju.Galiu išrašyti saskaitą-fakturą. Patirtis virš 20 metu. ',
                    'is_confirmed' => true,
                ],
                [
                    'reference' => 'laiptines-dazymas-atsakymas',
                    'advert' => 'laiptines-dazymas',
                    'email' => 'martyna@rangove.lt',
                    'text' => 'Glaistymo, dažymo darbai,tapetavimas ir kiti apdailos darbai, 12m patirtis',
                    'is_confirmed' => true,
                ],
            ];
    }
}
