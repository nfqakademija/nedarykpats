<?php

namespace App\Controller;

use App\Helpers\Pagination;
use App\Entity\Category;
use App\Helpers\PaginationHelper;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\SearchObjects\Filters;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param CategoryRepository $categoryRepository
     * @param PaginationHelper $paginationHelper
     * @return Response
     */
    public function index(
        Request $request,
        AdvertRepository $advertRepository,
        CategoryRepository $categoryRepository,
        PaginationHelper $paginationHelper
    ) {
        $page = $paginationHelper->getPageInput($request);

        $filters = new Filters();
        $selectedCategories = [];

        if ($request->query->get('filter') != null) {
            $selectedCategories = explode(',', $request->query->get('filter'));
        }

        $filters->setKeywords($selectedCategories);

        $filteredAdverts = $advertRepository->findByCategories($filters, $page, PaginationHelper::ITEMS_PER_PAGE);

        $paginationPages = ceil($filteredAdverts->count() / PaginationHelper::ITEMS_PER_PAGE);

        if ($page > $paginationPages) {
            $this->redirect('/');
        }

        $availableCategories = $categoryRepository->findAvailableCategoriesForFilter();

        return $this->render('home/index.html.twig', [
            'selectedCategorySlugs' => $selectedCategories,
            'availableCategories' => $availableCategories,
            'paginationPages' => $paginationPages,
            'filteredAdverts' => $filteredAdverts->getIterator(),
            'page' => $page,
            'toggleQueryStrings' => $this->buildToggleQueryStrings($availableCategories, $selectedCategories)
        ]);
    }

    /**
     * @param array|Category[] $availableCategories
     * @param array|string[] $selectedCategorySlugs
     * @return array
     */
    private function buildToggleQueryStrings(array $availableCategories, array $selectedCategorySlugs): array
    {
        $toggleQueryStrings = [];
        foreach ($availableCategories as $availableCategory) {
            $slug = $availableCategory->getSlug();

            if (in_array($slug, $selectedCategorySlugs)) {
                $toggleQueryStrings[$slug] = strtr(implode(',', $selectedCategorySlugs), [$slug => '']);
            } else {
                $toggleQueryStrings[$slug] = implode(',', $selectedCategorySlugs) . ',' . $slug;
            }

            $toggleQueryStrings[$slug] = trim($toggleQueryStrings[$slug], ',');
            $toggleQueryStrings[$slug] = strtr($toggleQueryStrings[$slug], [',,' => ',']);
        }

        return $toggleQueryStrings;
    }


    /**
     * @Route("/template", name="template")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailTemplate()
    {
        return $this->render('email_templates/password_was_changed.html.twig', []);
    }
}
