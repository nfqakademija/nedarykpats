<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $category1 = new Category();
        $category1->setSlug('statybos');
        $category1->setTitle('Statybos');
        $category1->setCssStyle('Category--orange');
        $manager->persist($category1);
        $manager->flush();

        $category2 = new Category();
        $category2->setSlug('remontas');
        $category2->setTitle('Remontas');
        $category2->setCssStyle('Category--lightGreen');
        $manager->persist($category2);
        $manager->flush();

        $category3 = new Category();
        $category3->setSlug('apdailos-darbai');
        $category3->setTitle('Apdailos darbai');
        $category3->setCssStyle('Category--lightBlue');
        $manager->persist($category3);
        $manager->flush();

        $category4 = new Category();
        $category4->setSlug('lauko-darbai');
        $category4->setTitle('Lauko darbai');
        $category4->setCssStyle('Category--purple');
        $manager->persist($category4);
        $manager->flush();

        $category5 = new Category();
        $category5->setSlug('santechnika');
        $category5->setTitle('Santechnika');
        $category5->setCssStyle('Category--green');
        $manager->persist($category5);
        $manager->flush();

        $category6 = new Category();
        $category6->setSlug('elektra');
        $category6->setTitle('Elektra');
        $category6->setCssStyle('Category--blue');
        $manager->persist($category6);
        $manager->flush();

        $category7 = new Category();
        $category7->setSlug('buitines-technikos-pajungimas');
        $category7->setTitle('Buitinės technikos pajungimas');
        $category7->setCssStyle('Category--yellow');
        $manager->persist($category7);
        $manager->flush();

        $category8 = new Category();
        $category8->setSlug('baldai');
        $category8->setTitle('Baldai');
        $category8->setCssStyle('Category--red');
        $manager->persist($category8);
        $manager->flush();

        $category9 = new Category();
        $category9->setSlug('kita');
        $category9->setTitle('Kita');
        $category9->setCssStyle('Category--brown');
        $manager->persist($category9);
        $manager->flush();


        $product = new Advert();
        $product->setTitle('Laiptinės dažymas ');
        $product->setText('Reikalingi profesionalūs dažytojai, mokantys ir galintys perdažyti mūsų namų laiptinę. Namas - 5 aukštų.');
        $product->setCategories($category3);
        $product->setCategories($category2);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Reikalingas elektrikas');
        $product->setText('Reikalingas elektrikas 700m2 namo elektros instaliacijai įrengti. Objektas Trakų/Elektrėnų rajone.');
        $product->setCategories($category6);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Vonios plytelių klijavimas');
        $product->setText('Norime atnaujinti vonią, ieškome plytelių klojėjo. Butas Vilniaus rajone, susiekimas automobiliu.');
        $product->setCategories($category3);
        $product->setCategories($category2);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Reikalingas Sodininkas');
        $product->setText('Reikalingas sodininkas privačiam namui Vilniuje (Antakalnis). Darbų apimtis: teritorijos tvarkymas, augalų sodinimas, ravėjimas, augalų ir medžių genėjimas ir t.t. Darbas pilna diena, 3-4 kartus per savaitę.');
        $product->setCategories($category4);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Ieškome santechniko');
        $product->setText('Reikalingas santechnikas visai buto santechnikai atnaujinti.');
        $product->setCategories($category5);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Ieškome silpnų srovių montotuojo');
        $product->setText('Ieškome silpnų srovių montotuojo. darbo pobūdis - kabelių ir įrangos montavimas. Silpnų srovių komutavimo ir sistemų paleidimų gebėjimas - privalumas.');
        $product->setCategories($category6);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Reikalingas darbų vadovas');
        $product->setText('Iešome darbų vadovo buto renovacijai. Butas - 60m2, mansarda, senamiestis.');
        $product->setCategories($category2);
        $product->setCategories($category3);
        $product->setCategories($category5);
        $product->setCategories($category6);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Buitinės technikos pajungimas');
        $product->setText('Reikia pajungti visą buitinę techniką (indaplovę, kaitlentę, skalbimo mašiną, šaldytuvą, gartraukį) naujoje virtuvėje. Vilnius (Pašilaičiai).');
        $product->setCategories($category7);
        $manager->persist($product);
        $manager->flush();

        $product = new Advert();
        $product->setTitle('Baldų išrinkimas/surinkimas');
        $product->setText('Kraustomės, reikia išrinkti visus baldus, o naujame bute surinkti. Vėliau būtų daugiau baldų, kuriuos reiktų surinkti');
        $product->setCategories($category2);
        $product->setCategories($category3);
        $product->setCategories($category5);
        $product->setCategories($category6);
        $manager->persist($product);
        $manager->flush();

        $offer = new Offer($product);
        $offer
            ->setText('Sveiki, galiu jums padėti šiuo klausimu. Vieno valandos kaina 12 Eur be PVM. Jeigu naudojamas mūsų transportas 14 Eur be PVM (esant didesniam atstumui nei 50 km, vieno kilometro kaina 0,5 Eur be PVM )')
            ->setEmail('paslaugos@krautykis-lengvai.lt');
        $manager->persist($offer);
        $manager->flush();

    }
}
