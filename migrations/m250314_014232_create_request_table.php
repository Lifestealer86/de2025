<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%service}}`
 */
class m250314_014232_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'service_id' => $this->integer(),
            'address' => $this->string()->notNull(),
            'contact_phone' => $this->string()->notNull(),
            'desired_datetime' => $this->dateTime()->notNull(),
            'custom_service_description' => $this->string(),
            'payment_method' => "ENUM('cash', 'card') NOT NULL",
            'status' => 'ENUM("new", "in_progress", "completed", "cancelled") DEFAULT "new"',
            'cancellation_reason' => $this->string(),
        ]);

        $this->createIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-request-service_id}}',
            '{{%request}}',
            'service_id'
        );

        $this->addForeignKey(
            '{{%fk-request-service_id}}',
            '{{%request}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}'
        );

        $this->dropIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}'
        );

        $this->dropForeignKey(
            '{{%fk-request-service_id}}',
            '{{%request}}'
        );

        $this->dropIndex(
            '{{%idx-request-service_id}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}
