<?php

namespace App\DataFixtures;

use App\Entity\ImageGallery;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageGalleryFixtures extends AbstractFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $availableImages = $this->getImages();
        $availableEmails = $this->getEmails();
        $advert = '';

        for ($i = 0; $i < count($availableImages); $i++) {
            if ($i % 2 === 0) {
                $advert = AdvertFixtures::ADVERT_FIXTURE . '-' . $i;
            }

            if (!$this->hasReference($advert)) {
                $randomUser = rand(0,3);
                $email = $availableEmails[$randomUser];

                $image = $this->createImage(__DIR__. '/images/'.$availableImages[$i], $availableImages[$i], null, $email);
                $manager->persist($image);
            } else {
                $image = $this->createImage(__DIR__. '/images/'.$availableImages[$i], $availableImages[$i], $advert, null);
                $manager->persist($image);
            }
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

    private function getImages() {
        $path = __DIR__ . '/images';
        $files = [];
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $files[] = $entry;
                }
            }
            closedir($handle);
        }
        return $files;
    }

    private function createImage(string $path, string $fileName, ?string $advert, ?string $user) {
        $uploadedFile = new UploadedFile(
            $path,
            $fileName,
            'image/*',
            null,
            true
        );
        $imageGallery = new ImageGallery();
        $imageGallery->setImageFile($uploadedFile);

        if ($advert !== null) {
            $imageGallery->setAdvert($this->getReference($advert));
        }
        if ($user !== null) {
            $imageGallery->setUser($this->getReference($user));
        }
        return $imageGallery;
    }

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
