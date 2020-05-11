<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200511132017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create cards table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE cards (id varchar(255) PRIMARY KEY, customer_id varchar(255), number varchar(255), created_at datetime)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE cards');
    }
}
