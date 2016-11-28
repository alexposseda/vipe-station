<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_lang}}`.
 */
class m161128_083939_create_product_lang_table extends Migration
{
    protected $tableName = '{{%product_lang}}';

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
            'product_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Product_Lang_TO_Product', $this->tableName, 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Product_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Product_Lang_TO_Product', $this->tableName);
        $this->dropForeignKey('FK_Product_Lang_TO_Language', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
