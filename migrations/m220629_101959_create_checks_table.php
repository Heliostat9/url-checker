<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checks}}`.
 */
class m220629_101959_create_checks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checks}}', [
            'id' => $this->primaryKey(),
            'date_check' => $this->dateTime(),
            'url_id' => $this->integer()->notNull(),
            'http_code' => $this->integer()->notNull(),
            'count_try' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-check-url-id',
            'checks',
            'url_id',
            'urls',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%checks}}');
    }
}
