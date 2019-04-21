<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $categories = [];
        foreach ($this->getCategoryData() as $singleCategory) {
            $category = $this->getCategory($singleCategory);
            $this->addReference($singleCategory['slug'], $category);
            $manager->persist($category);
            $categories[$singleCategory['slug']] = $category;
        }

        $adverts = [];
        $date = new \DateTime(date('Y-m-d'));
        foreach ($this->getAdvertsData() as $singleAdvert) {
            $date->modify('-1 day');
            $advert = $this->getAdvert($singleAdvert, $categories, $date->format('Y-m-d H:i:s'));
            $this->addReference($singleAdvert['reference'], $advert);
            $manager->persist($advert);
            $adverts[$singleAdvert['reference']] = $advert;
        }

        foreach ($this->getOfferData() as $singleOffer) {
            $offer = $this->getOffer($singleOffer, $adverts);
            $this->addReference($singleOffer['reference'], $offer);
            $manager->persist($offer);
        }

        $manager->flush();
    }

    /**
     * @param array $category
     * @return Category
     */
    private function getCategory(array $category)
    {
        return (new Category())
            ->setTitle($category['name'])
            ->setSlug($category['slug'])
            ->setCssStyle($category['cssStyle']);
    }

    /**
     * @param array $advert
     * @param array $categories
     * @param string $date
     * @return Advert
     * @throws \Exception
     */
    private function getAdvert(array $advert, array $categories, string $date)
    {
        $singleAdvert = new Advert();
        $singleAdvert
            ->setTitle($advert['title'])
            ->setText($advert['text'])
            ->setCreatedAt(new \DateTime($date));
        foreach ($advert['categories'] as $category) {
            $singleAdvert->setCategories($categories[$category]);
        }
        return $singleAdvert;
    }

    private function getOffer(array $offer, array $adverts)
    {
        return (new Offer($adverts[$offer['advert']]))
            ->setEmail($offer['email'])
            ->setText($offer['text']);
    }

    /**
     * @return array
     */
    private function getCategoryData()
    {
        return
            [
                [
                    'name' => 'Statybos',
                    'slug' => 'statybos',
                    'cssStyle' => 'Category--orange',
                ],
                [
                    'name' => 'Remontas',
                    'slug' => 'remontas',
                    'cssStyle' => 'Category--lightGreen',
                ],
                [
                    'name' => 'Apdailos darbai',
                    'slug' => 'apdailos-darbai',
                    'cssStyle' => 'Category--lightBlue',
                ],
                [
                    'name' => 'Lauko darbai',
                    'slug' => 'lauko-darbai',
                    'cssStyle' => 'Category--purple',
                ],
                [
                    'name' => 'Santechnika',
                    'slug' => 'santechnika',
                    'cssStyle' => 'Category--green',
                ],
                [
                    'name' => 'Elektra',
                    'slug' => 'elektra',
                    'cssStyle' => 'Category--blue',
                ],
                [
                    'name' => 'Buitinės technikos pajungimas',
                    'slug' => 'buitines-technikos-pajungimas',
                    'cssStyle' => 'Category--yellow',
                ],
                [
                    'name' => 'Baldai',
                    'slug' => 'baldai',
                    'cssStyle' => 'Category--red',
                ],
                [
                    'name' => 'Kita',
                    'slug' => 'kita',
                    'cssStyle' => 'Category--brown',
                ],
                [
                    'name' => 'Interjero dizainas',
                    'slug' => 'interjero-dizainas',
                    'cssStyle' => 'Category--red',
                ],
            ];
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
                    'title' => 'Laiptinės dažymas',
                    'categories' => ['statybos', 'remontas'],
                    'text' => 'Reikalingi profesionalūs dažytojai, mokantys ir galintys perdažyti mūsų namų laiptinę. Namas - 5 aukštų.',
                ],
                [
                    'reference' => 'reikalingas-elektrikas',
                    'title' => 'Reikalingas elektrikas',
                    'categories' => ['elektra'],
                    'text' => 'Reikalingas elektrikas 700m2 namo elektros instaliacijai įrengti. Objektas Trakų/Elektrėnų rajone.',
                ],
                [
                    'reference' => 'vonios-plyteliu',
                    'title' => 'Vonios plytelių klijavimas',
                    'categories' => ['apdailos-darbai', 'remontas'],
                    'text' => 'Norime atnaujinti vonią, ieškome plytelių klojėjo. Butas Vilniaus rajone, susiekimas automobiliu.',
                ],
                [
                    'reference' => 'reikalingas-sodininkas',
                    'title' => 'Reikalingas Sodininkas',
                    'categories' => ['lauko-darbai'],
                    'text' => 'Reikalingas sodininkas privačiam namui Vilniuje (Antakalnis). Darbų apimtis: teritorijos tvarkymas, augalų sodinimas, ravėjimas, augalų ir medžių genėjimas ir t.t. Darbas pilna diena, 3-4 kartus per savaitę.',
                ],
                [
                    'reference' => 'ieskome-santechniko',
                    'title' => 'Ieškome santechniko',
                    'categories' => ['remontas', 'santechnika'],
                    'text' => 'Reikalingas santechnikas visai buto santechnikai atnaujinti.',
                ],
                [
                    'reference' => 'silpnu-sroviu-montotuojas',
                    'title' => 'Ieškome silpnų srovių montotuojo',
                    'categories' => ['elektra'],
                    'text' => 'Ieškome silpnų srovių montotuojo. darbo pobūdis - kabelių ir įrangos montavimas. Silpnų srovių komutavimo ir sistemų paleidimų gebėjimas - privalumas.',
                ],
                [
                    'reference' => 'darbų-vadovas',
                    'title' => 'Reikalingas darbų vadovas',
                    'categories' => ['remontas', 'apdailos-darbai', 'elektra', 'santechnika'],
                    'text' => 'Iešome darbų vadovo buto renovacijai. Butas - 60m2, mansarda, senamiestis.',
                ],
                [
                    'reference' => 'darbų-vadovas-2',
                    'title' => 'Statybos vadovas Utenoje',
                    'categories' => ['remontas', 'apdailos-darbai', 'statybos'],
                    'text' => 'Ieškome atestuoto statybos darbų vadovo nedidelių objektų statybos darbams, t.p.griovimo darbams. Reikalavimai: vairuotojo pažymėjimas, dokumentų pildymas, darbas su klientais, jų paieška. Galime suteikti gyvenamąjį plotą darbo dienomis.',
                ],
                [
                    'reference' => 'technikos-pajungimas',
                    'title' => 'Buitinės technikos pajungimas',
                    'categories' => ['buitines-technikos-pajungimas'],
                    'text' => 'Reikia pajungti visą buitinę techniką (indaplovę, kaitlentę, skalbimo mašiną, šaldytuvą, gartraukį) naujoje virtuvėje. Vilnius (Pašilaičiai).',
                ],
                [
                    'reference' => 'baldu-isrinkimas',
                    'title' => 'Baldų išrinkimas/surinkimas',
                    'categories' => ['remontas', 'baldai', 'kita'],
                    'text' => 'Kraustomės, reikia išrinkti visus baldus, o naujame bute surinkti. Vėliau būtų daugiau baldų, kuriuos reiktų surinkti',
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
                    'email' => 'paslaugos@krautykis-lengvai.lt',
                    'text' => 'Sveiki, galiu jums padėti šiuo klausimu. Vieno valandos kaina 12 Eur be PVM. Jeigu naudojamas mūsų transportas 14 Eur be PVM (esant didesniam atstumui nei 50 km, vieno kilometro kaina 0,5 Eur be PVM',
                ],
                [
                    'reference' => 'technikos-pajungimas-atsakymas',
                    'advert' => 'technikos-pajungimas',
                    'email' => 'remontas@gmail.com',
                    'text' => 'Individualiai taisau visus buitinius (ir ne tik) elektros prietaisus, atlieku visus elektros instaliacijos darbus, montuoju ir pajungiu.',
                ],
                [
                    'reference' => 'technikos-pajungimas-atsakymas-2',
                    'advert' => 'technikos-pajungimas',
                    'email' => 'meistras@kmail.lt',
                    'text' => 'Skalbimo mašinų, indaplovių, gartraukių, viryklių ir kitos technikos pajungimas. Visos kainos yra sutartinės.',
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas',
                    'advert' => 'darbų-vadovas',
                    'email' => 'darbu@kvadovas.lt',
                    'text' => 'Atestuotas techninis prižiūrėtojas, statybų vadovas, turintis ilgametę (15 metų) patirtį statinio statybų (darbų) vadovo pareigose, atlieka statinių statybų techninę priežiūrą (gyvenamieji ir negyvenamieji pastatai). Galiu vykdyti priežiūrą kas stato ūkio būdu ir konsultuoti su statyba susijusiais įvairiais klausimais. Turiu patirties su karkasinių namų statyba. Tikrinu pastatus ar pastatyti pagal projektą, statybos taisykles, statybos techninius reglamentus (STR) ar atitinka visus keliamus reikalavimus.',
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas-2',
                    'advert' => 'darbų-vadovas',
                    'email' => 'jonas@mail.lt',
                    'text' => 'Atestuotas techninės priežiūros vadovas, statybos vadovas papildomai atlieka techninę priežiūrą individualiems ir kt. statiniams.',
                ],
                [
                    'reference' => 'darbų-vadovas-atsakymas-3',
                    'advert' => 'darbų-vadovas',
                    'email' => 'meistras@kgmail.lt',
                    'text' => 'Statybų vadovo paslaugos statantiems ūkio būdu, konsultacijos. Ypatingi (neypatingi) gyvenamieji ir negyvenamieji pastatai, kultūros paveldo objektai. Dirbame visoje Lietuvoje.',
                ],
                [
                    'reference' => 'montotuojas-atsakymas',
                    'advert' => 'silpnu-sroviu-montotuojas',
                    'email' => 'elektrikai@mail.lt',
                    'text' => 'Specialistai, turintys ilgametę patirtį elektros instaliacijos srityje, atlieka lauko ir vidaus elektros instaliaciją, konsultuoja, pataria, padeda išsirinkti optimalų sprendimą, paruošia dokumentus ESO.',
                ],
                [
                    'reference' => 'ieskome-santechniko-atsakymas',
                    'advert' => 'ieskome-santechniko',
                    'email' => 'paslaugos@krautykis-lengvai.lt',
                    'text' => 'KODĖL VERTA SKAMBINTI BŪTENT MAN? OPERATYVUMAS: Priklausomai nuo darbų apimties ir pobūdžio dirbu vienas, o reikalui esant – kooperuojuosi. Jūsų patogumui – paslaugas teikiu ir savaitgaliais. PARTNERIAI: Bendradarbiauju su ilgamečiais, geriausią kokybės ir kainos santykį siūlančiais medžiagų tiekėjais. Dėka gero apyvartumo, sugebu suderėti aukštas nuolaidas. Dirbu ir su šeimininko medžiagomis. KONKURENCINGUMAS: Man nereikia išlaikyti vadybininkų, buhalterių ir direktorių "ant savo sprando", todėl galiu pasiūlyti konkurencingas paslaugų kainas bei suteikti NUOLAIDAS didesnės apimties montavimo darbams. MANDAGUMAS: Bendrauju maloniai ir korektiškai. Suteikiu visapusišką informaciją, dažniausiai galite rinktis iš kelių įmanomų variantų.',
                ],
                [
                    'reference' => 'ieskome-santechniko-atsakymas-2',
                    'advert' => 'ieskome-santechniko',
                    'email' => 'santechnikas@gmail.com',
                    'text' => 'Santechnikas Vilniuje operatyviai ir profesionaliai atlieka visus santechnikos montavimo ir remonto darbus.',
                ],
                [
                    'reference' => 'reikalingas-sodininkas-atsakymas',
                    'advert' => 'reikalingas-sodininkas',
                    'email' => 'sodininkas-petras@kgmail.com',
                    'text' => 'Turiu darbo patirties šiose pareigose. Taip pat atlieku smulkius santechnikos,remonto ir kitus darbus.',
                ],
                [
                    'reference' => 'vonios-plyteliu-atsakymas',
                    'advert' => 'vonios-plyteliu',
                    'email' => 'meistras@info.lt',
                    'text' => 'Kokybiškai klijuoju visu rūšių plyteles,plytelių supjovimas 45 laipsnių kampu,nuolydžių formavimas,hidroizoliacijos įrengimas ,sienų bei grindų lyginimas ir kiti papildomi darbai. Konsultuoju.Galiu išrašyti saskaitą-fakturą. Patirtis virš 20 metu. ',
                ],
                [
                    'reference' => 'laiptines-dazymas-atsakymas',
                    'advert' => 'laiptines-dazymas',
                    'email' => 'remontas@mail.lt',
                    'text' => 'Glaistymo, dažymo darbai,tapetavimas ir kiti apdailos darbai, 12m patirtis',
                ],
            ];
    }
}
