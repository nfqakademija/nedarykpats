<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Offer;
use App\Entity\User;
use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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

        $cities = [];
        foreach ($this->getCityData() as $cityData){
            $city = $this->getCity($cityData);
            $this->addReference($cityData['name'], $city);
            $manager->persist($city);
            $cities[$cityData['name']] = $city;

        }


        $users = [];
        foreach ($this->getUserData() as $userData) {
            $user = $this->getUser($userData, $cities);
            $this->addReference($userData['email'], $user);
            $manager->persist($user);
            $users[$userData['email']] = $user;
        }

        $adverts = [];
        $date = new \DateTime(date('Y-m-d'));
        foreach ($this->getAdvertsData() as $singleAdvert) {
            $date->modify('-1 day');
            $advert = $this->getAdvert($singleAdvert, $categories, $date->format('Y-m-d H:i:s'), $users, $cities);
            $this->addReference($singleAdvert['reference'], $advert);
            $manager->persist($advert);
            $adverts[$singleAdvert['reference']] = $advert;
        }

        foreach ($this->getOfferData() as $singleOffer) {
            $offer = $this->getOffer($singleOffer, $adverts, $users);
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
     * @param array $userData
     * @return User
     * @throws \Exception
     */
    private function getUser(array $userData, array $cities)
    {
        $user = new User();
        $user->setEmail($userData['email'])
            ->setName($userData['name'])
            ->setCity($cities[$userData['city']])
            ->setRoles($userData['roles'])
            ->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']))
            ->setCreatedAt(new \DateTime('now'))
            ->setIsConfirmed($userData['is_confirmed']);

        if ($userData['descriptions']) {
            $user->setDescription($userData['descriptions']);
        }
        return $user;
    }

    /**
     * @param array $advert
     * @param array $categories
     * @param string $date
     * @param array $users
     * @return Advert
     * @throws \Exception
     */
    private function getAdvert(array $advert, array $categories, string $date, array $users, array $cities)
    {

        $singleAdvert = new Advert();
        $singleAdvert
            ->setTitle($advert['title'])
            ->setText($advert['text'])
            ->setCreatedAt(new \DateTime($date))
            ->setCity($cities[$advert['city']])
            ->setUser($users[$advert['email']])
            ->setIsConfirmed($advert['is_confirmed']);

        $collection = new ArrayCollection();

        foreach ($advert['categories'] as $category) {

            $collection->add($categories[$category]);

            $singleAdvert->addCategory($categories[$category]);

        }
        return $singleAdvert;
    }

    /**
     * @param array $offer
     * @param array $adverts
     * @param array $users
     * @return Offer
     * @throws \Exception
     */
    private function getOffer(array $offer, array $adverts, array $users)
    {
        return (new Offer())
            ->setUser($users[$offer['email']])
            ->setText($offer['text'])
            ->setAdvert($adverts[$offer['advert']])
            ->setCreatedAt(new \DateTime('now'))
            ->setIsConfirmed($offer['is_confirmed']);
    }


    /**
     * @param array $cityData
     * @return City
     */
    private function getCity( array $cityData)
    {
        $city = new City();

        $city->setName($cityData['name'])
            ->setPosition($cityData['position']);

        return $city;
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
    private function getUserData()
    {
        return
            [
                [
                    'email' => 'aurimas@uzsakovas.lt',
                    'password' => 'aurimas',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => false,
                    'name' => 'Aurimas Vilys',
                    'descriptions' => '',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'martyna@uzsakove.lt',
                    'password' => 'martyna',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Martyna B',
                    'descriptions' => '',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'vilius@uzsakovas.lt',
                    'password' => 'vilius',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Vilius Gumonis',
                    'descriptions' => '',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'laurynas@uzsakovas.lt',
                    'password' => 'laurynas',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Laurynas Valenta',
                    'descriptions' => '',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'aurimas@rangovas.lt',
                    'password' => 'aurimas',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Aurimas Vilys',
                    'descriptions' => 'Profesionalus sienų dažytojas',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'martyna@rangove.lt',
                    'password' => 'martyna',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Martyna B',
                    'descriptions' => 'Profesionali interjero dizainerė',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'vilius@rangovas.lt',
                    'password' => 'vilius',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Vilius Gumonis',
                    'descriptions' => 'Profesionalus  santechnikas',
                    'city' => 'Vilnius',
                ],
                [
                    'email' => 'laurynas@rangovas.lt',
                    'password' => 'laurynas',
                    'roles' => ['ROLE_USER'],
                    'is_confirmed' => true,
                    'name' => 'Laurynas Valenta',
                    'descriptions' => 'Profesionalus darbų vykdytojas',
                    'city' => 'Vilnius',
                ],
            ];
    }


    private function getCityData()
    {
        return [
            [
                'name' => 'Vilnius',
                'position' => 'primary'
            ],
            [
                'name' => 'Kaunas',
                'position' => 'primary'
            ],
            [
                'name' => 'Klaipėda',
                'position' => 'primary'
            ],

            [
                'name' => 'Šiauliai',
                'position' => 'primary'
            ],

            [
                'name' => 'Panevežys',
                'position' => 'primary'
            ],

            [
                'name' => 'Alytus',
                'position' => 'primary'
            ],
            [
                'name' => 'Marijampolė',
                'position' => 'primary'
            ],
            [
                'name' => 'Akmenė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Anykščiai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Birštonas',
                'position' => 'secondary'
            ],
            [
                'name' => 'Druskininkai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Elektrėnai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Ignalina',
                'position' => 'secondary'
            ],
            [
                'name' => 'Jonava',
                'position' => 'secondary'
            ],
            [
                'name' => 'Joniškis',
                'position' => 'secondary'
            ],
            [
                'name' => 'Jurbankas',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kaišiadoriai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kalvarijai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kazlų Ruda',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kėdainiai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kelmė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kretinga',
                'position' => 'secondary'
            ],
            [
                'name' => 'Kupiškis',
                'position' => 'secondary'
            ],
            [
                'name' => 'Lazdijai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Mažeikiai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Molėtai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Neringa',
                'position' => 'secondary'
            ],
            [
                'name' => 'Paktruoniis',
                'position' => 'secondary'
            ],
            [
                'name' => 'Plungė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Prienai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Radviliškis',
                'position' => 'secondary'
            ],
            [
                'name' => 'Raseiniai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Rietavas',
                'position' => 'secondary'
            ],
            [
                'name' => 'Šakiai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Šalčinikai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Šilalė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Širvintai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Tauragė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Telšiai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Trakai',
                'position' => 'secondary'
            ],
            [
                'name' => 'Ukmergė',
                'position' => 'secondary'
            ],
            [
                'name' => 'Varėna',
                'position' => 'secondary'
            ],
            [
                'name' => 'Vilkaviškis',
                'position' => 'secondary'
            ],
            [
                'name' => 'Visaginas',
                'position' => 'secondary'
            ],
            [
                'name' => 'Zarasai',
                'position' => 'secondary'
            ]
        ];

    }


}
