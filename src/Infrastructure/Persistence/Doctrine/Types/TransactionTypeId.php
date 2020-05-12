<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use PineappleCard\Domain\Transaction\TransactionId;

class TransactionTypeId extends StringType
{
    const MYTYPE = 'transaction_id';

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
        return new TransactionId($value);
    }
}
