<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends AbstractFixture implements ORMFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategoryData() as $categoryData) {
            $category = $this->createCategory($categoryData);
            $manager->persist($category);
        }
        $manager->flush();
    }


    /**
     * @param array $categoryData
     * @return Category
     */
    private function createCategory(array $categoryData)
    {
        $category = new Category();

        $category->setTitle($categoryData['name'])
            ->setSlug($categoryData['slug'])
            ->setCssStyle($categoryData['cssStyle']);

        $this->addReference($categoryData['slug'], $category);

        return $category;
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
                    'name' => 'Kasdieniai darbai',
                    'slug' => 'kasdieniai-darbai',
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
}
