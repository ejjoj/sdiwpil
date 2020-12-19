<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201219094910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinic (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_patient (clinic_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_41BB2013CC22AD4 (clinic_id), INDEX IDX_41BB20136B899279 (patient_id), PRIMARY KEY(clinic_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, second_name VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, major_discipline VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_patient (doctor_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_8977B44687F4FB17 (doctor_id), INDEX IDX_8977B4466B899279 (patient_id), PRIMARY KEY(doctor_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_clinic (doctor_id INT NOT NULL, clinic_id INT NOT NULL, INDEX IDX_A31FC83987F4FB17 (doctor_id), INDEX IDX_A31FC839CC22AD4 (clinic_id), PRIMARY KEY(doctor_id, clinic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, second_name VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, pesel_number INT NOT NULL, date_of_birth DATE NOT NULL, place_of_birth VARCHAR(255) NOT NULL, fathers_first_name VARCHAR(255) NOT NULL, mothers_first_name VARCHAR(255) NOT NULL, mothers_maiden_name VARCHAR(255) NOT NULL, profession VARCHAR(255) DEFAULT NULL, education VARCHAR(255) DEFAULT NULL, marital_state VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, doctor_id INT NOT NULL, clinic_id INT NOT NULL, UNIQUE INDEX UNIQ_437EE9396B899279 (patient_id), UNIQUE INDEX UNIQ_437EE93987F4FB17 (doctor_id), UNIQUE INDEX UNIQ_437EE939CC22AD4 (clinic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_patient ADD CONSTRAINT FK_41BB2013CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clinic_patient ADD CONSTRAINT FK_41BB20136B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_patient ADD CONSTRAINT FK_8977B44687F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_patient ADD CONSTRAINT FK_8977B4466B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_clinic ADD CONSTRAINT FK_A31FC83987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_clinic ADD CONSTRAINT FK_A31FC839CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9396B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clinic_patient DROP FOREIGN KEY FK_41BB2013CC22AD4');
        $this->addSql('ALTER TABLE doctor_clinic DROP FOREIGN KEY FK_A31FC839CC22AD4');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939CC22AD4');
        $this->addSql('ALTER TABLE doctor_patient DROP FOREIGN KEY FK_8977B44687F4FB17');
        $this->addSql('ALTER TABLE doctor_clinic DROP FOREIGN KEY FK_A31FC83987F4FB17');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93987F4FB17');
        $this->addSql('ALTER TABLE clinic_patient DROP FOREIGN KEY FK_41BB20136B899279');
        $this->addSql('ALTER TABLE doctor_patient DROP FOREIGN KEY FK_8977B4466B899279');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9396B899279');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE clinic_patient');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE doctor_patient');
        $this->addSql('DROP TABLE doctor_clinic');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE visit');
    }
}
