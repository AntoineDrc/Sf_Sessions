<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022124240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATETIME NOT NULL, city VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern_session (intern_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_A6D9BBE2525DD4B4 (intern_id), INDEX IDX_A6D9BBE2613FECDF (session_id), PRIMARY KEY(intern_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_C24262812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, capacity INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_D044D5D45200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_module (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, module_id INT NOT NULL, duration INT NOT NULL, INDEX IDX_634F2C71613FECDF (session_id), INDEX IDX_634F2C71AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATETIME NOT NULL, city VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, photo VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intern_session ADD CONSTRAINT FK_A6D9BBE2525DD4B4 FOREIGN KEY (intern_id) REFERENCES intern (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intern_session ADD CONSTRAINT FK_A6D9BBE2613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C24262812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE session_module ADD CONSTRAINT FK_634F2C71613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session_module ADD CONSTRAINT FK_634F2C71AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intern_session DROP FOREIGN KEY FK_A6D9BBE2525DD4B4');
        $this->addSql('ALTER TABLE intern_session DROP FOREIGN KEY FK_A6D9BBE2613FECDF');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C24262812469DE2');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('ALTER TABLE session_module DROP FOREIGN KEY FK_634F2C71613FECDF');
        $this->addSql('ALTER TABLE session_module DROP FOREIGN KEY FK_634F2C71AFC2B591');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE intern');
        $this->addSql('DROP TABLE intern_session');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_module');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
