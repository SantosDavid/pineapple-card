<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200512014840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create invoices table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE invoices(id varchar(255) primary key, customer_id varchar(255), pay_day integer(2), created_at datetime, paid boolean)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE invoices');
    }
}
