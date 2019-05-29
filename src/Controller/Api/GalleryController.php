<?php

namespace App\Controller\Api;

use App\Entity\ImageGallery;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class GalleryController extends AbstractController
{
    /**
     * @Route("api/public/gallery", name="api_get_gallery", methods={"GET"})
     * @param Request $request
     * @param UploaderHelper $uploaderHelper
     * @param CacheManager $cacheManager
     * @return Response
     */
    public function getImagesJson(Request $request, UploaderHelper $uploaderHelper, CacheManager $cacheManager)
    {
        $user = $request->query->get('user');
        $advert = $request->query->get('advert');

        if ($user && $advert) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
        $imageGalleryRepository = $this->getDoctrine()->getRepository(ImageGallery::class);
        $images = $imageGalleryRepository->findByUserHashOrAdvertID($user, $advert);

        $return_array = [];
        /** @var ImageGallery $image */
        foreach ($images as $image) {
            $path = $uploaderHelper->asset($image, 'imageFile');
            $path = $cacheManager->getBrowserPath($path, 'resize_standard');
            array_push($return_array, ['src' => $path, 'width' => 4, 'height' => 3]);
        }

        return new Response(json_encode($return_array), Response::HTTP_OK);
    }
}
