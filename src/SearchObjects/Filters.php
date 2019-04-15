<?php


namespace App\SearchObjects;


class Filters
{
    private $keywords;

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     * @return Filters
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }



}