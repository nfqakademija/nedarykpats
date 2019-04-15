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
     * @param array|Category[] $availableCategories
     * @param array|string[] $selectedCategorySlugs
     * @return array
     */
    private function buildToggleQueryStrings(array $availableCategories, array $selectedCategorySlugs) : array
    {
        $categories = [];
        foreach ($availableCategories as $availableCategory)
        {
            if(in_array($availableCategory->getSlug(), $selectedCategorySlugs)) {
                $categories[$availableCategory->getSlug()] =
                    strtr(
                    implode(',', $selectedCategorySlugs),
                    [$availableCategory->getSlug() => '']
                    );
            }
            else {
                $categories[$availableCategory->getSlug()] = implode(',', $selectedCategorySlugs) . ',' . $availableCategory->getSlug();
            }

            $categories[$availableCategory->getSlug()] = trim($categories[$availableCategory->getSlug()], ',');
            $categories[$availableCategory->getSlug()] = strtr(
                $categories[$availableCategory->getSlug()],
                [',,' => '']
            );
        }

        return $categories;
    }
}
