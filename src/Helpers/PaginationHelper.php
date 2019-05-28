<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Request;

class PaginationHelper
{

    public const ITEMS_PER_PAGE = 6;

    /**
     * @param Request $request
     * @return int
     */
    public function getPageInput(Request $request)
    {
        $pageInput = $request->query->get('page') ? $request->query->get('page') : 1;
        $pageCastToInt = ctype_digit($pageInput) ? $pageInput : 1;
        $page = $pageCastToInt > 0 ? $pageCastToInt : 1;

        return $page;
    }
}
