<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Offer;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\SearchObjects\Filters;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class HomeController extends AbstractController
{

    const ITEMS_PER_PAGE = 6;

    /**
     *  @Route("/", name="home")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, AdvertRepository $advertRepository, CategoryRepository $categoryRepository)
    {

        $page = $request->query->get('page') ? $request->query->get('page') : 1;

        $filters = new Filters();
        $selectedCategories = [];

        if ($request->query->get('filter') != null) {
            $selectedCategories = explode(',', $request->query->get('filter'));
        }

        $filters->setKeywords($selectedCategories);

        $filteredAdverts = $advertRepository->findByCategories($filters, $page, self::ITEMS_PER_PAGE);

        $availableCategories = $categoryRepository->findAvailableCategoriesForFilter();

        $paginationPages = ceil($filteredAdverts->count() / self::ITEMS_PER_PAGE);


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
     * @Route("/advert/{id}", name="advert", requirements={"id"="\d+"})
     * @ParamConverter("advert", class="App:Advert")
     * @param Advert $advert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function advert(
        Advert $advert,
        Request $request
    ) {

        $offer = new Offer($advert);

        $offerForm = $this->createFormBuilder($offer)
            ->add('email')
            ->add('text')
            ->add('save', SubmitType::class, ['label' => 'Siųsti'])
            ->getForm();

        $offerForm->handleRequest($request);

        if ($offerForm->isSubmitted() && $offerForm->isValid()) {
            $offer = $offerForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            $this->addFlash('success', 'Siūlymas išsaugotas');

            return $this->redirect($request->getUri());
        }

        return $this->render('home/advert.html.twig', [
            'advert' => $advert,
            'offerForm' => $offerForm->createView(),
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
}
