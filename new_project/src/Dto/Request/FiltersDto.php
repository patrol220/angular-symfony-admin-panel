<?php

namespace App\Dto\Request;

class FiltersDto {

    /**
     * @var array|null
     */
    private $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return array|null
     */
    public function getFilters(): ?array
    {
        return $this->filters;
    }
}
