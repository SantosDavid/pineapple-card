<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200512130240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Crete transactions table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE transactions(id varchar(255) primary key, card_id varchar(255), value_amount decimal(10, 2), value_currency char(3), establishment_category int(2), establishment_geolocation_latitude varchar(255), establishment_geolocation_longitude varchar(255), created_at datetime)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE transactions');
    }
}
