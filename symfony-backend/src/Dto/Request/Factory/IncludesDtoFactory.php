<?php

namespace App\Dto\Request\Factory;

use App\Dto\Request\IncludesDto;
use Symfony\Component\HttpFoundation\Request;

class IncludesDtoFactory
{
    public static function createFromRequest(Request $request): IncludesDto
    {
        $includes = $request->get('include') !== null ? explode(',', $request->get('include')) : null;

        return new IncludesDto($includes);
    }
}
