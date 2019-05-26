<?php

namespace App\SearchObjects;

class Filters
{
    /**
     * @var string[]
     */
    private $keywords;

    /**
     * @var string[]
     */
    private $advertStatuses;

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

    /**
     * @return string[]
     */
    public function getAdvertStatuses()
    {
        return $this->advertStatuses;
    }

    /**
     * @param array $advertStatuses
     * @return Filters
     */
    public function setAdvertStatuses(array $advertStatuses): Filters
    {
        $this->advertStatuses = $advertStatuses;

        return $this;
    }
}
