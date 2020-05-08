<?php

namespace App\Exception;

use Throwable;

class ItemNotFoundInDatabaseException extends \Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message)) {
            $message = "Item not found in database";
        }
        parent::__construct($message, $code, $previous);
    }
}
