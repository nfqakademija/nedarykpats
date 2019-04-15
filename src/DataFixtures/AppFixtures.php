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
        $category1->setSlug('baldai');
        $category1->setTitle('Baldai');
        $manager->persist($category1);
        $manager->flush();

        $category2 = new Category();
        $category2->setSlug('santechnika');
        $category2->setTitle('Santechnika');
        $manager->persist($category2);
        $manager->flush();

        $category3 = new Category();
        $category3->setSlug('vidaus-apdaila');
        $category3->setTitle('Vidaus apdaia');
        $manager->persist($category3);
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
