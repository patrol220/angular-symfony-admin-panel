<?php

namespace App\Dto\Request\Factory;

use App\Dto\Request\FiltersDto;
use Symfony\Component\HttpFoundation\Request;

class FiltersDtoFactory {
    public static function createFromRequest(Request $request) {
        $filters = $request->get('filter');

        return new FiltersDto($filters);
    }
}
