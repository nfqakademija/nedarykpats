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
        $category1->setCSSClass('Category--orange');
        $manager->persist($category1);
        $manager->flush();

        $category2 = new Category();
        $category2->setSlug('remontas');
        $category2->setTitle('Remontas');
        $category2->setCSSClass('Category--lightGreen');
        $manager->persist($category2);
        $manager->flush();

        $category3 = new Category();
        $category3->setSlug('apdailos-darbai');
        $category3->setTitle('Apdailos darbai');
        $category3->setCSSClass('Category--lightBlue');
        $manager->persist($category3);
        $manager->flush();

        $category4 = new Category();
        $category4->setSlug('lauko-darbai');
        $category4->setTitle('Lauko darbai');
        $category4->setCSSClass('Category--purple');
        $manager->persist($category4);
        $manager->flush();

        $category5 = new Category();
        $category5->setSlug('santechnika');
        $category5->setTitle('Santechnika');
        $category5->setCSSClass('Category--green');
        $manager->persist($category5);
        $manager->flush();

        $category6 = new Category();
        $category6->setSlug('elektra');
        $category6->setTitle('Elektra');
        $category6->setCSSClass('Category--blue');
        $manager->persist($category6);
        $manager->flush();

        $category7 = new Category();
        $category7->setSlug('buitines-technikos-pajungimas');
        $category7->setTitle('Buitinės technikos pajungimas');
        $category7->setCSSClass('Category--yellow');
        $manager->persist($category7);
        $manager->flush();

        $category8 = new Category();
        $category8->setSlug('baldai');
        $category8->setTitle('Baldai');
        $category8->setCSSClass('Category--red');
        $manager->persist($category8);
        $manager->flush();

        $category9 = new Category();
        $category9->setSlug('kita');
        $category9->setTitle('Kita');
        $category9->setCSSClass('Category--brown');
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

            $manager->persist($product);
        }
        $manager->flush();
    }
}
