<?php

namespace App\Dto\Request\Factory;

use App\Dto\Request\PaginationDto;
use Symfony\Component\HttpFoundation\Request;

class PaginationDtoFactory
{
    public static function createFromRequest(Request $request): PaginationDto
    {
        $page = $request->get('page');
        $route = $request->attributes->get('_route');
        $routeParams = $request->attributes->get('_route_params');
        $queryParams = $request->query->all();

        $pageNumber = $page['number'] ?? 1;
        $pageSize = $page['size'] ?? 20;

        return new PaginationDto($pageNumber, $pageSize, $route, $routeParams, $queryParams);
    }
}
