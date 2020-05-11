<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511150751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create transactions table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE transactions (id varchar(255) primary key, card_id varchar(255), value_amount decimal(10, 2), value_currency varchar(3), establishment_category integer(3), establishment_geolocation_latitude varchar(255), establishment_geolocation_longitude varchar(255), created_at datetime)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
