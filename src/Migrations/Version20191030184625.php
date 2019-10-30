<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030184625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO public.users (id, login, password, roles, created, updated) VALUES ('94b945c2-d89d-4f5d-b372-4ec0b8529bbf', 'foo', '\$argon2id\$v=19\$m=65536,t=4,p=1\$nvzNwZ/eCFjFCm2tJszjrQ\$KpZ1WBDw9LTdu4Xtp+TyvLohSNFDFpAgIEt/MTuNrEg', 'ROLE_FOO', '2019-10-30 18:48:44', null)");
        $this->addSql("INSERT INTO public.users (id, login, password, roles, created, updated) VALUES ('02aa8326-090a-4356-9695-2c8ae268eaec', 'bar', '\$argon2id\$v=19\$m=65536,t=4,p=1\$H1AtDJg2M/t3dYov8jyFZA\$DouLwtG6zvKUooXPpv95zRE0fW19p315aymzei2tCI8', 'ROLE_BAR', '2019-10-30 18:48:44', null)");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
