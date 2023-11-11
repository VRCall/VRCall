<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111152919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE avatars_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE friend_chat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE friends_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_chat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_members_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE groups_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rooms_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE avatars (id INT NOT NULL, owner_id INT NOT NULL, skin VARCHAR(7) NOT NULL, shirt VARCHAR(7) NOT NULL, pants VARCHAR(7) NOT NULL, hair VARCHAR(7) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0C985207E3C61F9 ON avatars (owner_id)');
        $this->addSql('CREATE TABLE friend_chat (id INT NOT NULL, friendship_id INT NOT NULL, sender_id INT NOT NULL, message TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FFE72E4AEA7E2197 ON friend_chat (friendship_id)');
        $this->addSql('CREATE INDEX IDX_FFE72E4AF624B39D ON friend_chat (sender_id)');
        $this->addSql('COMMENT ON COLUMN friend_chat.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE friends (id INT NOT NULL, is_pending BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE friends_user (friends_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(friends_id, user_id))');
        $this->addSql('CREATE INDEX IDX_48FBBB49CA8337 ON friends_user (friends_id)');
        $this->addSql('CREATE INDEX IDX_48FBBBA76ED395 ON friends_user (user_id)');
        $this->addSql('CREATE TABLE group_chat (id INT NOT NULL, groups_id INT NOT NULL, sender_id INT NOT NULL, message TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CC7A9DAF373DCF ON group_chat (groups_id)');
        $this->addSql('CREATE INDEX IDX_4CC7A9DAF624B39D ON group_chat (sender_id)');
        $this->addSql('COMMENT ON COLUMN group_chat.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE group_members (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE group_members_user (group_members_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(group_members_id, user_id))');
        $this->addSql('CREATE INDEX IDX_2EBFBCD56ACC945F ON group_members_user (group_members_id)');
        $this->addSql('CREATE INDEX IDX_2EBFBCD5A76ED395 ON group_members_user (user_id)');
        $this->addSql('CREATE TABLE group_members_groups (group_members_id INT NOT NULL, groups_id INT NOT NULL, PRIMARY KEY(group_members_id, groups_id))');
        $this->addSql('CREATE INDEX IDX_80FED70C6ACC945F ON group_members_groups (group_members_id)');
        $this->addSql('CREATE INDEX IDX_80FED70CF373DCF ON group_members_groups (groups_id)');
        $this->addSql('CREATE TABLE groups (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rooms (id INT NOT NULL, code VARCHAR(6) NOT NULL, users INT NOT NULL, environment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE avatars ADD CONSTRAINT FK_B0C985207E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friend_chat ADD CONSTRAINT FK_FFE72E4AEA7E2197 FOREIGN KEY (friendship_id) REFERENCES friends (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friend_chat ADD CONSTRAINT FK_FFE72E4AF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBB49CA8337 FOREIGN KEY (friends_id) REFERENCES friends (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE friends_user ADD CONSTRAINT FK_48FBBBA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_chat ADD CONSTRAINT FK_4CC7A9DAF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_chat ADD CONSTRAINT FK_4CC7A9DAF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_members_user ADD CONSTRAINT FK_2EBFBCD56ACC945F FOREIGN KEY (group_members_id) REFERENCES group_members (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_members_user ADD CONSTRAINT FK_2EBFBCD5A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_members_groups ADD CONSTRAINT FK_80FED70C6ACC945F FOREIGN KEY (group_members_id) REFERENCES group_members (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_members_groups ADD CONSTRAINT FK_80FED70CF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE avatars_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE friend_chat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE friends_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_chat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_members_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE groups_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rooms_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE avatars DROP CONSTRAINT FK_B0C985207E3C61F9');
        $this->addSql('ALTER TABLE friend_chat DROP CONSTRAINT FK_FFE72E4AEA7E2197');
        $this->addSql('ALTER TABLE friend_chat DROP CONSTRAINT FK_FFE72E4AF624B39D');
        $this->addSql('ALTER TABLE friends_user DROP CONSTRAINT FK_48FBBB49CA8337');
        $this->addSql('ALTER TABLE friends_user DROP CONSTRAINT FK_48FBBBA76ED395');
        $this->addSql('ALTER TABLE group_chat DROP CONSTRAINT FK_4CC7A9DAF373DCF');
        $this->addSql('ALTER TABLE group_chat DROP CONSTRAINT FK_4CC7A9DAF624B39D');
        $this->addSql('ALTER TABLE group_members_user DROP CONSTRAINT FK_2EBFBCD56ACC945F');
        $this->addSql('ALTER TABLE group_members_user DROP CONSTRAINT FK_2EBFBCD5A76ED395');
        $this->addSql('ALTER TABLE group_members_groups DROP CONSTRAINT FK_80FED70C6ACC945F');
        $this->addSql('ALTER TABLE group_members_groups DROP CONSTRAINT FK_80FED70CF373DCF');
        $this->addSql('DROP TABLE avatars');
        $this->addSql('DROP TABLE friend_chat');
        $this->addSql('DROP TABLE friends');
        $this->addSql('DROP TABLE friends_user');
        $this->addSql('DROP TABLE group_chat');
        $this->addSql('DROP TABLE group_members');
        $this->addSql('DROP TABLE group_members_user');
        $this->addSql('DROP TABLE group_members_groups');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
