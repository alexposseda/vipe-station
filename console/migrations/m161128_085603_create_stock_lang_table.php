<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_lang}}`.
 */
class m161128_085603_create_stock_lang_table extends Migration
{
    protected $tableName = '{{%stock_lang}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),

            'title' => $this->string(),
            'description' => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Stock_Lang_TO_Stock', $this->tableName, 'stock_id', '{{%stock}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Stock_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Stock_Lang_TO_Stock', $this->tableName);
        $this->dropForeignKey('FK_Stock_Lang_TO_Language', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
