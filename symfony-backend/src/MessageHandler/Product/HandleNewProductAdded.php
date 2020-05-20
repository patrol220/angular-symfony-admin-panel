<?php

namespace App\MessageHandler\Product;

use App\Message\Product\NewProductAdded;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class HandleNewProductAdded implements MessageHandlerInterface
{
    public function __invoke(NewProductAdded $newProductAdded)
    {
        dump('invoked');
    }
}
