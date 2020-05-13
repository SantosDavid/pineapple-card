<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200512235832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add invoice_id field';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE transactions ADD COLUMN invoice_id varchar(255)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
