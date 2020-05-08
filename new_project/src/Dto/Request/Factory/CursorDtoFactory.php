<?php

namespace App\Dto\Request\Factory;

use App\Dto\Request\CursorDto;
use Symfony\Component\HttpFoundation\Request;

class CursorDtoFactory
{
    public static function createFromRequest(): CursorDto
    {
        $request = Request::createFromGlobals();

        $cursor = $request->get('cursor', null);
        $previous = $request->get('previous', null);
        $limit = $request->get('limit', 20) >= 0 ? $request->get('limit', 20) : 0;

        return new CursorDto($cursor, $previous, $limit);
    }
}
