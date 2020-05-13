<?php

declare(strict_types=1);

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513021854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add establish name and score rate to transactions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE transactions ADD COLUMN establishment_name varchar(255)');
        $this->addSql('ALTER TABLE transactions ADD COLUMN establishment_score_rate decimal(8,2)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
