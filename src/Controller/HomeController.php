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
            'someVariable' => 'NFQ Akademija',
            'selectedCategories' => $selectedCategories,
            'availableCategories' => $availableCategories,
            'filteredAdverts' => $filteredAdverts
        ]);
    }
}
