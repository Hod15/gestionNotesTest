<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402183029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_880E0D76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controle (id INT AUTO_INCREMENT NOT NULL, module_id INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_E39396EAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controle_etudiant (controle_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_566CF412758926A6 (controle_id), INDEX IDX_566CF412DDEAB1A3 (etudiant_id), PRIMARY KEY(controle_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, at VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_81A72FA1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignement (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_BD310CCAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, promotion_id INT NOT NULL, UNIQUE INDEX UNIQ_717E22E3A76ED395 (user_id), INDEX IDX_717E22E3139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_C242628E455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, controle_id INT NOT NULL, note SMALLINT NOT NULL, UNIQUE INDEX UNIQ_CFBDFA14DDEAB1A3 (etudiant_id), UNIQUE INDEX UNIQ_CFBDFA14758926A6 (controle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_C11D7DD1CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regroupement_module (id INT AUTO_INCREMENT NOT NULL, promotion_id INT NOT NULL, unite_enseignement_id INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_D4C38968139DF194 (promotion_id), INDEX IDX_D4C3896818DEEBA5 (unite_enseignement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regroupement_module_module (regroupement_module_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_73723AFCC8A9EF74 (regroupement_module_id), INDEX IDX_73723AFCAFC2B591 (module_id), PRIMARY KEY(regroupement_module_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite_enseignement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, last_login DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396EAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE controle_etudiant ADD CONSTRAINT FK_566CF412758926A6 FOREIGN KEY (controle_id) REFERENCES controle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controle_etudiant ADD CONSTRAINT FK_566CF412DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enseignement ADD CONSTRAINT FK_BD310CCAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14758926A6 FOREIGN KEY (controle_id) REFERENCES controle (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE regroupement_module ADD CONSTRAINT FK_D4C38968139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE regroupement_module ADD CONSTRAINT FK_D4C3896818DEEBA5 FOREIGN KEY (unite_enseignement_id) REFERENCES unite_enseignement (id)');
        $this->addSql('ALTER TABLE regroupement_module_module ADD CONSTRAINT FK_73723AFCC8A9EF74 FOREIGN KEY (regroupement_module_id) REFERENCES regroupement_module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE regroupement_module_module ADD CONSTRAINT FK_73723AFCAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE controle_etudiant DROP FOREIGN KEY FK_566CF412758926A6');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14758926A6');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1CCF9E01E');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628E455FCC0');
        $this->addSql('ALTER TABLE controle_etudiant DROP FOREIGN KEY FK_566CF412DDEAB1A3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396EAFC2B591');
        $this->addSql('ALTER TABLE enseignement DROP FOREIGN KEY FK_BD310CCAFC2B591');
        $this->addSql('ALTER TABLE regroupement_module_module DROP FOREIGN KEY FK_73723AFCAFC2B591');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3139DF194');
        $this->addSql('ALTER TABLE regroupement_module DROP FOREIGN KEY FK_D4C38968139DF194');
        $this->addSql('ALTER TABLE regroupement_module_module DROP FOREIGN KEY FK_73723AFCC8A9EF74');
        $this->addSql('ALTER TABLE regroupement_module DROP FOREIGN KEY FK_D4C3896818DEEBA5');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76A76ED395');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1A76ED395');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE controle');
        $this->addSql('DROP TABLE controle_etudiant');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE enseignement');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE regroupement_module');
        $this->addSql('DROP TABLE regroupement_module_module');
        $this->addSql('DROP TABLE unite_enseignement');
        $this->addSql('DROP TABLE user');
    }
}
