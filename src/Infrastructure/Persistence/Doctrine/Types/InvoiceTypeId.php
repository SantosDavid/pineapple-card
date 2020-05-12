<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use PineappleCard\Domain\Invoice\InvoiceId;

class InvoiceTypeId extends StringType
{
    const MYTYPE = 'invoice_id';

    public function getName()
    {
        return self::MYTYPE;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new InvoiceId($value);
    }
}
