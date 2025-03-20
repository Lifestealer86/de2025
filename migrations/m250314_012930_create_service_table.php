<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m250314_012930_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
        ]);

        $this->batchInsert('service', ['name'], [
            ['общий клининг'],
            ['генеральная уборка'],
            ['послестроительная уборка'],
            ['химчистка ковров и мебели']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service}}');
    }
}
