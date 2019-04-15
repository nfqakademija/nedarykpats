<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use App\SearchObjects\Filters;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, AdvertRepository $advertRepository)
    {
        $filters = new Filters();
        $selectedCategories = [];

        if($request->query->get('filter') != null)
            $selectedCategories = explode(',',$request->query->get('filter'));

        $filters->setKeywords($selectedCategories);

        $filteredAdverts = $advertRepository->findByCategories($filters);

        return $this->render('home/index.html.twig', [
            'someVariable' => 'NFQ Akademija',
            'selectedCategories' => $selectedCategories,
            'filteredAdverts' => $filteredAdverts
        ]);
    }
}
