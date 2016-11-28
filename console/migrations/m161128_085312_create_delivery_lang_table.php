<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_lang}}`.
 */
class m161128_085312_create_delivery_lang_table extends Migration
{
    protected $tableName = '{{%delivery_lang}}';

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
            'delivery_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),

            'name' => $this->string(),
            'description' => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Delivery_Lang_TO_Delivery', $this->tableName, 'delivery_id', '{{%delivery}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Delivery_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Delivery_Lang_TO_Delivery', $this->tableName);
        $this->dropForeignKey('FK_Delivery_Lang_TO_Language', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
