<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Feedback;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {


        foreach ($this->getOfferData() as $singleOffer) {
            $offer = $this->getOffer($singleOffer);
            $this->addReference($singleOffer['reference'], $offer);
            $manager->persist($offer);
        }
//        foreach ($this->getFeedbackData() as $singleFeedbackData) {
//            $feedback = $this->getFeedback($singleFeedbackData, $users, $adverts);
//            $manager->persist($feedback);
//        }
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
            UserFixtures::class,
            AdvertFixtures::class
        ];
    }


    /**
     * @param array $advert
     * @param string $date
     * @param array $users
     * @return Advert
     * @throws \Exception
     */
    private function getAdvert(array $advert, string $date)
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
        return $singleAdvert;
    }

    /**
     * @param array $offer
     * @return Offer
     * @throws \Exception
     */
    private function getOffer(array $offer)
    {
        return (new Offer())
            ->setUser($this->getReference($offer['email']))
            ->setText($offer['text'])
            ->setAdvert($this->getReference($offer['advert']))
            ->setCreatedAt(new \DateTime('now'))
            ->setIsConfirmed($offer['is_confirmed']);
    }


    /**
     * @param array $feedbackData
     * @param array $users
     * @param array $adverts
     * @return Feedback
     * @throws \Exception
     */
    private function getFeedback(array $feedbackData, array $users, array $adverts)
    {
        $feedback = new Feedback();
        $feedback->setReceivingUser($users[$feedbackData['receivingUser']])
            ->setScore($feedbackData['score'])
            ->setAdvert($adverts[$feedbackData['advert']])
            ->setMessage($feedbackData['message'])
            ->setCreatedAt(new \DateTime('now'));
        return $feedback;
    }


    /**
     * @return array
     */
    private function getAdvertsData()
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


    /**
     * @return array
     */
    public function getFeedbackData()
    {
        return [
            [
                'score' => '0',
                'message' => 'Tobulas darbuotojas',
                'advert' => 'ieskome-santechniko',
                'receivingUser' => 'aurimas@uzsakovas.lt',
            ],
            [
                'score' => '2',
                'message' => 'Tobulas darbuotojas',
                'advert' => 'silpnu-sroviu-montotuojas',
                'receivingUser' => 'martyna@uzsakove.lt',
            ],
        ];
    }
}