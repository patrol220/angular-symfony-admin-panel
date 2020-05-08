<?php

namespace App\Dto\Request;

class SortDto
{
    const SORT_DIR_ASC = 'ASC';
    const SORT_DIR_DESC = 'DESC';

    /**
     * @var string
     */
    private $sortField;

    /**
     * @var string
     */
    private $sortDirection;

    public function __construct(string $sortField, string $sortDirection)
    {
        if ($sortDirection !== self::SORT_DIR_ASC && $sortDirection !== self::SORT_DIR_DESC) {
            throw new \InvalidArgumentException();
        }

        if ($sortField === '') {
            throw new \InvalidArgumentException();
        }

        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    /**
     * @return string
     */
    public function getSortField(): string
    {
        return $this->sortField;
    }

    /**
     * @return string
     */
    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }
}
