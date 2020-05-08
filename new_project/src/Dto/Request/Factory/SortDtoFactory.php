<?php

namespace App\Dto\Request\Factory;

use App\Dto\Request\SortDto;
use Symfony\Component\HttpFoundation\Request;

class SortDtoFactory
{
    public static function createFromRequest()
    {
        $request = Request::createFromGlobals();

        $sort = $request->get('sort', 'id');

        if (substr($sort, 0, 1) === '-') {
            return new SortDto(ltrim($sort, '-'), SortDto::SORT_DIR_DESC);
        }
        return new SortDto($sort, SortDto::SORT_DIR_ASC);
    }
}
