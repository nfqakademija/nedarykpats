<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
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

        // Bam!
        for ($i = 0; $i < 20; $i++) {

            $product = new Advert();
            $product->setTitle('product '.$i);
            $product->setText(mt_rand(10, 100));
            $product->setCategories($i % 2 == 0 ? $category1 : $category2);
            if($i % 3 == 0) {
                $product->setCategories($category3);
            }
            if($i % 4 == 0) {
                $product->setCategories($category4);
            }
            if($i % 5 == 0) {
                $product->setCategories($category5);
                $product->setCategories($category6);
            }
            if ($i % 6 == 0) {
                $product->setCategories($category7);
            }
            if($i % 7 == 0) {
                $product->setCategories($category8);
                $product->setCategories($category9);
            }

            $manager->persist($product);
        }
        $manager->flush();
    }
}
