<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\SearchObjects\Filters;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, AdvertRepository $advertRepository, CategoryRepository $categoryRepository)
    {
        $filters = new Filters();
        $selectedCategories = [];

        if($request->query->get('filter') != null)
            $selectedCategories = explode(',',$request->query->get('filter'));

        $filters->setKeywords($selectedCategories);
        $filteredAdverts = $advertRepository->findByCategories($filters);

        $availableCategories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'selectedCategorySlugs' => $selectedCategories,
            'availableCategories' => $availableCategories,
            'filteredAdverts' => $filteredAdverts,
            'toggleQueryStrings' => $this->buildToggleQueryStrings($availableCategories, $selectedCategories)
        ]);
    }

    /**
     * @Route("/advert/{id}", name="advert", requirements={"id"="\d+"})
     * @param int $id
     * @param AdvertRepository $advertRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function advert(int $id, AdvertRepository $advertRepository){
        $advert = $advertRepository->find($id);
        return $this->render('home/advert.html.twig', [
            'advert' => $advert
        ]);
    }

    /**
     * @param array|Category[] $availableCategories
     * @param array|string[] $selectedCategorySlugs
     * @return array
     */
    private function buildToggleQueryStrings(array $availableCategories, array $selectedCategorySlugs) : array
    {
        $toggleQueryStrings = [];
        foreach ($availableCategories as $availableCategory)
        {
            if(in_array($availableCategory->getSlug(), $selectedCategorySlugs)) {
                $toggleQueryStrings[$availableCategory->getSlug()] =
                    strtr(
                    implode(',', $selectedCategorySlugs),
                    [$availableCategory->getSlug() => '']
                    );
            }
            else {
                $toggleQueryStrings[$availableCategory->getSlug()] = implode(',', $selectedCategorySlugs) . ',' . $availableCategory->getSlug();
            }

            $toggleQueryStrings[$availableCategory->getSlug()] = trim($toggleQueryStrings[$availableCategory->getSlug()], ',');
            $toggleQueryStrings[$availableCategory->getSlug()] = strtr(
                $toggleQueryStrings[$availableCategory->getSlug()],
                [',,' => ',']
            );
        }

        return $toggleQueryStrings;
    }
}
