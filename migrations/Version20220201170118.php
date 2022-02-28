<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201170118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE snow_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snow_comment (id INT AUTO_INCREMENT NOT NULL, snow_figure_id INT DEFAULT NULL, snow_user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1B93B5CC95A95560 (snow_figure_id), INDEX IDX_1B93B5CC28893435 (snow_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snow_figure (id INT AUTO_INCREMENT NOT NULL, snow_category_id INT NOT NULL, snow_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, publish TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_AD2EECA69FB8B958 (snow_category_id), INDEX IDX_AD2EECA628893435 (snow_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snow_image (id INT AUTO_INCREMENT NOT NULL, snow_figure_id INT DEFAULT NULL, src VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B496190995A95560 (snow_figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snow_video (id INT AUTO_INCREMENT NOT NULL, snow_figure_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D6CC77A95A95560 (snow_figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE snow_comment ADD CONSTRAINT FK_1B93B5CC95A95560 FOREIGN KEY (snow_figure_id) REFERENCES snow_figure (id)');
        $this->addSql('ALTER TABLE snow_comment ADD CONSTRAINT FK_1B93B5CC28893435 FOREIGN KEY (snow_user_id) REFERENCES snow_user (id)');
        $this->addSql('ALTER TABLE snow_figure ADD CONSTRAINT FK_AD2EECA69FB8B958 FOREIGN KEY (snow_category_id) REFERENCES snow_category (id)');
        $this->addSql('ALTER TABLE snow_figure ADD CONSTRAINT FK_AD2EECA628893435 FOREIGN KEY (snow_user_id) REFERENCES snow_user (id)');
        $this->addSql('ALTER TABLE snow_image ADD CONSTRAINT FK_B496190995A95560 FOREIGN KEY (snow_figure_id) REFERENCES snow_figure (id)');
        $this->addSql('ALTER TABLE snow_video ADD CONSTRAINT FK_D6CC77A95A95560 FOREIGN KEY (snow_figure_id) REFERENCES snow_figure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snow_figure DROP FOREIGN KEY FK_AD2EECA69FB8B958');
        $this->addSql('ALTER TABLE snow_comment DROP FOREIGN KEY FK_1B93B5CC95A95560');
        $this->addSql('ALTER TABLE snow_image DROP FOREIGN KEY FK_B496190995A95560');
        $this->addSql('ALTER TABLE snow_video DROP FOREIGN KEY FK_D6CC77A95A95560');
        $this->addSql('DROP TABLE snow_category');
        $this->addSql('DROP TABLE snow_comment');
        $this->addSql('DROP TABLE snow_figure');
        $this->addSql('DROP TABLE snow_image');
        $this->addSql('DROP TABLE snow_video');
    }
}
