<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class CityFixtures extends AbstractFixture implements ORMFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCityData() as $cityData) {
            $city = $this->createCity($cityData);
            $manager->persist($city);
        }

        $manager->flush();
    }


    /**
     * @param array $cityData
     * @return City
     */
    public function createCity(array $cityData)
    {
        $city = new City();

        $city->setName($cityData['name'])
            ->setPosition($cityData['position']);

        $this->addReference(
            $cityData['name'],
            $city
        );

        return $city;
    }

    /**
     * @return array
     */
    public function getCityData()
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
