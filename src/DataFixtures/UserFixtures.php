<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
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
        foreach ($this->getUserData() as $userData) {
            $user = $this->createUser($userData);
            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            CityFixtures::class
        ];
    }

    /**
     * @param array $userData
     * @return User
     * @throws \Exception
     */
    private function createUser(array $userData)
    {
        $user = new User();

        $user->setEmail($userData['email'])
            ->setName($userData['name'])
            ->setCity($this->getReference($userData['city']))
            ->setRoles($userData['roles'])
            ->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']))
            ->setCreatedAt(new \DateTime('now'))
            ->setIsConfirmed($userData['is_confirmed'])
            ->setIdentification(md5(microtime()));

        if ($userData['descriptions']) {
            $user->setDescription($userData['descriptions']);
        }

        $this->addReference(
            $userData['email'],
            $user
        );

        return $user;
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
                    'name' => 'Martyna Bikulčiutė',
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
                    'name' => 'Martyna Bikulčiutė',
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
}
