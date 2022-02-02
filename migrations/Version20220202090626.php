<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202090626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snow_comment CHANGE snow_figure_id snow_figure_id INT NOT NULL, CHANGE snow_user_id snow_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE snow_image CHANGE snow_figure_id snow_figure_id INT NOT NULL');
        $this->addSql('ALTER TABLE snow_user ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE snow_video CHANGE snow_figure_id snow_figure_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snow_comment CHANGE snow_figure_id snow_figure_id INT DEFAULT NULL, CHANGE snow_user_id snow_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE snow_image CHANGE snow_figure_id snow_figure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE snow_user DROP avatar');
        $this->addSql('ALTER TABLE snow_video CHANGE snow_figure_id snow_figure_id INT DEFAULT NULL');
    }
}
