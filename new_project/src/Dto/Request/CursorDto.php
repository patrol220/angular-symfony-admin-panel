<?php

namespace App\Dto\Request;

class CursorDto {

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var int|null
     */
    private $previous;

    /**7
     * @var int
     */
    private $limit;

    public function __construct(?string $cursor, ?string $previous, int $limit)
    {
        $this->cursor = $cursor;
        $this->previous = $previous;
        $this->limit = $limit;
    }

    /**
     * @return string|null
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string|null
     */
    public function getPrevious(): ?string
    {
        return $this->previous;
    }
}
