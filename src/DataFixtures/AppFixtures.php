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


        // Bam!
        for ($i = 0; $i < 20; $i++) {

            $category = new Category();
            $category->setSlug();
            $category->setTitle();

            $product = new Advert();
            $product->setTitle('product '.$i);
            $product->setText(mt_rand(10, 100));
            $product->setCategories( $category);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
