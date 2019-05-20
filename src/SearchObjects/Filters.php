<?php

namespace App\SearchObjects;

class Filters
{
    /**
     * @var string[]
     */
    private $keywords;

    /**
     * @var int
     */
    private $advertStatus;

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
     * @return int
     */
    public function getAdvertStatus(): ?int
    {
        return $this->advertStatus;
    }

    /**
     * @param int $advertStatus
     * @return Filters
     */
    public function setAdvertStatus(int $advertStatus): Filters
    {
        $this->advertStatus = $advertStatus;
        return $this;
    }
}
