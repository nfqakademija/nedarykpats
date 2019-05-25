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
        $counter = 0;

        $availableTexts = $this->getOfferTexts();
        $availableEmails = $this->getEmails();

        while (true) {
            $referenceKey = AdvertFixtures::ADVERT_FIXTURE . '-' . $counter;

            if (!$this->hasReference($referenceKey)) {
                break;
            }

            if ($counter % 4 === 0) {
                $counter++;
                continue;
            }

            $offersCount = rand(1, 4);
            for ($i = 0; $i < $offersCount; $i++) {
                $offer = $this->createOffer([
                    'advert' => $referenceKey,
                    'email' => $availableEmails[($counter + $i) % count($availableEmails)],
                    'text' => $availableTexts[($counter + $i) % count($availableTexts)]
                ]);

                $manager->persist($offer);
            }

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
            ->setCreatedAt(new \DateTime())
            ->setIsConfirmed(true);

        return $offer;
    }


    /**
     * @return array
     */
    private function getOfferTexts()
    {
        return [
            'Sveiki, galiu jums padėti šiuo klausimu. Vieno valandos kaina 12 Eur be PVM. Jeigu naudojamas mūsų transportas 14 Eur be PVM (esant didesniam atstumui nei 50 km, vieno kilometro kaina 0,5 Eur be PVM',
            'Individualiai taisau visus buitinius (ir ne tik) elektros prietaisus, atlieku visus elektros instaliacijos darbus, montuoju ir pajungiu.',
            'Skalbimo mašinų, indaplovių, gartraukių, viryklių ir kitos technikos pajungimas. Visos kainos yra sutartinės.',
            'Atestuotas techninis prižiūrėtojas, statybų vadovas, turintis ilgametę (15 metų) patirtį statinio statybų (darbų) vadovo pareigose, atlieka statinių statybų techninę priežiūrą (gyvenamieji ir negyvenamieji pastatai). Galiu vykdyti priežiūrą kas stato ūkio būdu ir konsultuoti su statyba susijusiais įvairiais klausimais. Turiu patirties su karkasinių namų statyba. Tikrinu pastatus ar pastatyti pagal projektą, statybos taisykles, statybos techninius reglamentus (STR) ar atitinka visus keliamus reikalavimus.',
            'Atestuotas techninės priežiūros vadovas, statybos vadovas papildomai atlieka techninę priežiūrą individualiems ir kt. statiniams.',
            'Statybų vadovo paslaugos statantiems ūkio būdu, konsultacijos. Ypatingi (neypatingi) gyvenamieji ir negyvenamieji pastatai, kultūros paveldo objektai. Dirbame visoje Lietuvoje.',
            'Specialistai, turintys ilgametę patirtį elektros instaliacijos srityje, atlieka lauko ir vidaus elektros instaliaciją, konsultuoja, pataria, padeda išsirinkti optimalų sprendimą, paruošia dokumentus ESO.',
            'KODĖL VERTA SKAMBINTI BŪTENT MAN? OPERATYVUMAS: Priklausomai nuo darbų apimties ir pobūdžio dirbu vienas, o reikalui esant – kooperuojuosi. Jūsų patogumui – paslaugas teikiu ir savaitgaliais. PARTNERIAI: Bendradarbiauju su ilgamečiais, geriausią kokybės ir kainos santykį siūlančiais medžiagų tiekėjais. Dėka gero apyvartumo, sugebu suderėti aukštas nuolaidas. Dirbu ir su šeimininko medžiagomis. KONKURENCINGUMAS: Man nereikia išlaikyti vadybininkų, buhalterių ir direktorių "ant savo sprando", todėl galiu pasiūlyti konkurencingas paslaugų kainas bei suteikti NUOLAIDAS didesnės apimties montavimo darbams. MANDAGUMAS: Bendrauju maloniai ir korektiškai. Suteikiu visapusišką informaciją, dažniausiai galite rinktis iš kelių įmanomų variantų.',
            'Santechnikas Vilniuje operatyviai ir profesionaliai atlieka visus santechnikos montavimo ir remonto darbus.',
            'Turiu darbo patirties šiose pareigose. Taip pat atlieku smulkius santechnikos,remonto ir kitus darbus.',
            'Kokybiškai klijuoju visu rūšių plyteles,plytelių supjovimas 45 laipsnių kampu,nuolydžių formavimas,hidroizoliacijos įrengimas ,sienų bei grindų lyginimas ir kiti papildomi darbai. Konsultuoju.Galiu išrašyti saskaitą-fakturą. Patirtis virš 20 metu. ',
            'Glaistymo, dažymo darbai,tapetavimas ir kiti apdailos darbai, 12m patirtis',
        ];
    }

    /**
     * @return array
     */
    private function getEmails()
    {
        return [
            'vilius@rangovas.lt',
            'laurynas@rangovas.lt',
            'aurimas@rangovas.lt',
            'martyna@rangove.lt',
        ];
    }
}
