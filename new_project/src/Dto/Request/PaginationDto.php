<?php

namespace App\Dto\Request;

class PaginationDto
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * @var string
     */
    private $route;

    /**
     * @var array
     */
    private $routeParams;

    /**
     * @var array
     */
    private $queryParams;

    public function __construct($page, $pageSize, $route, $routeParams, $queryParams)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->queryParams = $queryParams;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
