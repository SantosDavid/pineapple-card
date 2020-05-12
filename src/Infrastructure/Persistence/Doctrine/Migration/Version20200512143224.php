<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200512143224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add refund field to transactions table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE transactions ADD refunded boolean');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
