<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use PineappleCard\Domain\Customer\CustomerId;

class CustomerTypeId extends StringType
{
    const MYTYPE = 'customer_id';

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
        return new CustomerId($value);
    }
}
