<?php

namespace App\Dto\Request;

class IncludesDto {

    /**
     * @var array|null
     */
    private $includes;

    public function __construct($includes)
    {
        $this->includes = $includes;
    }

    /**
     * @return array|null
     */
    public function getIncludes(): ?array
    {
        return $this->includes;
    }
}
