<?php

namespace App\Controller;

use App\Constant\Pagination;
use App\Entity\Category;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, AdvertRepository $advertRepository, CategoryRepository $categoryRepository)
    {
        $page = $this->getPageInput($request);

        $filters = new Filters();
        $selectedCategories = [];

        if ($request->query->get('filter') != null) {
            $selectedCategories = explode(',', $request->query->get('filter'));
        }

        $filters->setKeywords($selectedCategories);

        $filteredAdverts = $advertRepository->findByCategories($filters, $page, Pagination::ITEMS_PER_PAGE);

        $paginationPages = ceil($filteredAdverts->count() / Pagination::ITEMS_PER_PAGE);

        if ($page > $paginationPages) {
            $page = $paginationPages;
            $filteredAdverts = $advertRepository->findByCategories($filters, $page, Pagination::ITEMS_PER_PAGE);
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

    //TODO: iskelti į AdvertController
    /**
     * @Route("/my-adverts", name="my_adverts")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function myAdvert(
        Request $request,
        AdvertRepository $advertRepository
    ): Response {
        $page = $this->getPageInput($request);
        $user = $this->getUser();

        $filters = new Filters();
        $statuses = [];

        if ($request->query->get('status') != null) {
            $statuses = explode(',', $request->query->get('status'));
        }

        $filters->setAdvertStatuses($statuses);

        $filteredAdverts = $advertRepository->findMyAdvertsByCategories(
            $user,
            $filters,
            $page,
            Pagination::ITEMS_PER_PAGE
        );

        $paginationPages = ceil($filteredAdverts->count() / Pagination::ITEMS_PER_PAGE);

        if ($paginationPages > 0 && $page > $paginationPages) {
            $page = $paginationPages;
            $filteredAdverts = $advertRepository
                ->findMyAdvertsByCategories($user, $filters, $page, Pagination::ITEMS_PER_PAGE);
        }

        return $this->render('advert/my_adverts.html.twig', [
            'paginationPages' => $paginationPages,
            'filteredAdverts' => $filteredAdverts->getIterator(),
            'page' => $page,
            'toggleStatus' => $this->buildStatusToggle($statuses),
            "status" => $statuses
        ]);
    }


    /**
     * @param array $selectedStatuses
     * @return array
     */
    private function buildStatusToggle(array $selectedStatuses): array
    {
        $status = [
            AdvertRepository::ADVERT_STATE_CURRENT,
            AdvertRepository::ADVERT_STATE_WITHOUT_FEEDBACK,
            AdvertRepository::ADVERT_STATE_HAS_FEEDBACK
        ];

        $statusToggle = [];
        foreach ($status as $state) {
            if (in_array($state, $selectedStatuses)) {
                $statusToggle[$state] = strtr(implode(',', $selectedStatuses), [$state => '']);
            } else {
                $statusToggle[$state] = implode(',', $selectedStatuses) . ',' . $state;
            }

            $statusToggle[$state] = trim($statusToggle[$state], ', ');
            $statusToggle[$state] = strtr($statusToggle[$state], [",," => ',']);
        }
        return $statusToggle;
    }

    /**
     * @param array|Category[] $availableCategories
     * @param array|string[] $selectedCategorySlugs
     * @return array
     */
    private function buildToggleQueryStrings(array $availableCategories, array $selectedCategorySlugs) : array
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
     * @param Request $request
     * @return int
     */
    private function getPageInput(Request $request)
    {
        $pageInput = $request->query->get('page') ? $request->query->get('page') : 1;
        $pageCastToInt =  ctype_digit($pageInput)  ? $pageInput : 1;
        $page = $pageCastToInt > 0 ? $pageCastToInt : 1;

        return $page;
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
