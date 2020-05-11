<?php

namespace PineappleCard\Domain\Transaction\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;

class InvalidEstablishmentCategoryException extends BaseException
{
    public function __construct(int $category)
    {
        parent::__construct("Category {$category} is not valid");
    }
}
