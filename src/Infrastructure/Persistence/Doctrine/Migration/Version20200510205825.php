<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200510205825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adding Auth to customer model';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE customers ADD auth_email varchar (255)');
        $this->addSql('ALTER TABLE customers ADD auth_password varchar(255)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
